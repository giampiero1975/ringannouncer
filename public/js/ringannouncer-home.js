var body = document.body;

document.querySelectorAll(".menu-toggle").forEach(function (button) {
    var bar = button.closest(".topbar");
    var close = function () {
        bar.classList.remove("is-open");
        body.classList.remove("menu-open");
        button.setAttribute("aria-expanded", "false");
    };

    button.addEventListener("click", function () {
        var open = bar.classList.toggle("is-open");
        body.classList.toggle("menu-open", open);
        button.setAttribute("aria-expanded", open ? "true" : "false");
    });

    bar.querySelectorAll(".nav a").forEach(function (link) {
        link.addEventListener("click", close);
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") close();
    });

    document.addEventListener("click", function (event) {
        if (!bar.contains(event.target)) close();
    });
});

document.querySelectorAll(".carousel").forEach(function (carousel) {
    var track = carousel.querySelector(".carousel-track");
    if (!track) return;

    var previous = carousel.querySelector("[data-carousel-prev]");
    var next = carousel.querySelector("[data-carousel-next]");
    var buttons = [previous, next].filter(Boolean);
    var update = function () {
        var max = track.scrollWidth - track.clientWidth;
        buttons.forEach(function (button) {
            button.disabled = max <= 2;
        });
        if (previous && max > 2) previous.disabled = track.scrollLeft <= 2;
        if (next && max > 2) next.disabled = track.scrollLeft >= max - 2;
    };

    var scrollToSibling = function (direction) {
        var items = [].slice.call(track.children);
        if (!items.length) return;

        var current = items.reduce(function (nearest, item, index) {
            var distance = Math.abs(item.offsetLeft - track.scrollLeft);
            return distance < nearest.distance ? { index: index, distance: distance } : nearest;
        }, { index: 0, distance: Infinity }).index;

        var nextIndex = Math.max(0, Math.min(items.length - 1, current + direction));
        track.scrollTo({
            left: items[nextIndex].offsetLeft,
            behavior: "smooth",
        });
    };

    buttons.forEach(function (button) {
        button.addEventListener("click", function () {
            scrollToSibling(button.hasAttribute("data-carousel-prev") ? -1 : 1);
        });
    });

    track.addEventListener("scroll", update, { passive: true });
    window.addEventListener("resize", update);
    update();
});

document.querySelectorAll("[data-gallery]").forEach(function (gallery) {
    var items = [].slice.call(gallery.querySelectorAll("[data-gallery-item]"));
    var pager = gallery.querySelector("[data-gallery-pager]");
    if (!items.length || !pager) return;

    var buttons = [].slice.call(pager.querySelectorAll("[data-gallery-page]"));
    var previous = gallery.querySelector("[data-carousel-prev]");
    var next = gallery.querySelector("[data-carousel-next]");
    var index = 0;
    var setActive = function (nextIndex) {
        index = (nextIndex + items.length) % items.length;
        items.forEach(function (item, itemIndex) {
            item.classList.toggle("big", itemIndex === index);
        });
        buttons.forEach(function (button, buttonIndex) {
            button.classList.toggle("is-active", buttonIndex === index);
            button.setAttribute("aria-current", buttonIndex === index ? "true" : "false");
        });
    };

    buttons.forEach(function (button) {
        button.addEventListener("click", function () {
            setActive(parseInt(button.getAttribute("data-gallery-page"), 10) || 0);
        });
    });

    previous?.addEventListener("click", function () {
        setActive(index - 1);
    });
    next?.addEventListener("click", function () {
        setActive(index + 1);
    });
    setActive(0);
});

var galleryModal = document.querySelector("[data-gallery-modal]");
if (galleryModal) {
    var galleryImage = galleryModal.querySelector("[data-gallery-image]");
    var galleryTitle = galleryModal.querySelector("[data-gallery-title]");
    var galleryTimer = null;
    var closeGallery = function () {
        if (galleryModal.hidden) return;
        window.clearTimeout(galleryTimer);
        galleryModal.classList.remove("is-open");
        galleryModal.classList.add("is-closing");
        body.classList.remove("modal-open");
        galleryTimer = window.setTimeout(function () {
            galleryModal.hidden = true;
            galleryModal.classList.remove("is-closing");
            if (galleryImage) {
                galleryImage.src = "";
                galleryImage.alt = "";
            }
        }, 260);
    };
    var openGallery = function (trigger) {
        var src = trigger.getAttribute("data-gallery-modal-image");
        var title = trigger.getAttribute("data-gallery-modal-title") || "Gallery";
        if (!src || !galleryImage) return;

        window.clearTimeout(galleryTimer);
        galleryImage.src = src;
        galleryImage.alt = title;
        if (galleryTitle) galleryTitle.textContent = title;
        galleryModal.classList.remove("is-closing");
        galleryModal.hidden = false;
        body.classList.add("modal-open");
        window.requestAnimationFrame(function () {
            galleryModal.classList.add("is-open");
        });
        galleryModal.querySelector("button[data-gallery-close]")?.focus();
    };

    document.querySelectorAll("[data-gallery-modal-image]").forEach(function (trigger) {
        trigger.addEventListener("click", function () {
            openGallery(trigger);
        });
        trigger.addEventListener("keydown", function (event) {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                openGallery(trigger);
            }
        });
    });

    galleryModal.addEventListener("click", function (event) {
        if (event.target.closest("[data-gallery-close]")) closeGallery();
    });
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && !galleryModal.hidden) closeGallery();
    });
}
document.querySelectorAll("[data-calendar]").forEach(function (calendar) {
    var grid = calendar.querySelector("[data-calendar-grid]");
    var monthLabel = calendar.querySelector("[data-calendar-month]");
    var yearLabel = calendar.querySelector("[data-calendar-year]");
    if (!grid || !monthLabel || !yearLabel) return;

    var today = new Date();
    var current = new Date(today.getFullYear(), today.getMonth(), 1);
    var events = [];

    try {
        events = JSON.parse(calendar.getAttribute("data-events") || "[]");
    } catch (error) {
        events = [];
    }

    var eventsByDate = events.reduce(function (map, event) {
        if (!event.date) return map;
        (map[event.date] = map[event.date] || []).push(event);
        return map;
    }, {});
    var formatter = new Intl.DateTimeFormat("it-IT", { month: "long" });
    var pad = function (value) {
        return String(value).padStart(2, "0");
    };
    var toKey = function (date) {
        return date.getFullYear() + "-" + pad(date.getMonth() + 1) + "-" + pad(date.getDate());
    };
    var eventText = function (dayEvents) {
        return dayEvents.map(function (event) {
            return event.venue ? event.title + " · " + event.venue : event.title;
        }).join("\\A");
    };

    var render = function () {
        monthLabel.textContent = formatter.format(current);
        yearLabel.textContent = current.getFullYear();
        calendar.setAttribute("aria-label", "Calendario eventi " + monthLabel.textContent + " " + current.getFullYear());
        grid.replaceChildren();

        var start = new Date(current.getFullYear(), current.getMonth(), 1);
        var offset = (start.getDay() + 6) % 7;
        start.setDate(start.getDate() - offset);

        for (var index = 0; index < 42; index++) {
            var day = new Date(start);
            day.setDate(start.getDate() + index);

            var key = toKey(day);
            var cell = document.createElement("span");
            var number = document.createElement("span");
            cell.className = "mini-calendar__day";

            if (day.getMonth() !== current.getMonth()) cell.classList.add("is-muted");
            if (key === toKey(today)) cell.classList.add("is-today");
            if (eventsByDate[key]) {
                var label = eventText(eventsByDate[key]);
                cell.classList.add("has-event");
                cell.tabIndex = 0;
                cell.dataset.tooltip = label;
                cell.setAttribute("aria-label", label.replace(/\\A/g, ", "));
            }

            number.textContent = day.getDate();
            cell.appendChild(number);
            grid.appendChild(cell);
        }
    };

    calendar.querySelector("[data-calendar-prev]")?.addEventListener("click", function () {
        current.setMonth(current.getMonth() - 1);
        render();
    });
    calendar.querySelector("[data-calendar-next]")?.addEventListener("click", function () {
        current.setMonth(current.getMonth() + 1);
        render();
    });
    calendar.querySelector("[data-calendar-today]")?.addEventListener("click", function () {
        current = new Date(today.getFullYear(), today.getMonth(), 1);
        render();
    });
    render();
});

var videoModal = document.querySelector("[data-video-modal]");
if (videoModal) {
    var frame = videoModal.querySelector("[data-video-frame]");
    var title = videoModal.querySelector("[data-video-title]");
    var closeVideo = function () {
        videoModal.hidden = true;
        body.classList.remove("modal-open");
        if (frame) frame.src = "";
    };

    document.querySelectorAll("[data-video-id]").forEach(function (trigger) {
        trigger.addEventListener("click", function () {
            var id = trigger.getAttribute("data-video-id");
            if (!id || !frame) return;
            if (title) title.textContent = trigger.getAttribute("data-video-title") || "Video";
            frame.src = "https://www.youtube-nocookie.com/embed/" + encodeURIComponent(id) + "?autoplay=1&rel=0";
            videoModal.hidden = false;
            body.classList.add("modal-open");
            videoModal.querySelector("[data-video-close]")?.focus();
        });
    });

    videoModal.addEventListener("click", function (event) {
        if (event.target.closest("[data-video-close]")) closeVideo();
    });
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && !videoModal.hidden) closeVideo();
    });
}

var lastFocus = null;
document.querySelectorAll("[data-modal-target]").forEach(function (trigger) {
    var open = function () {
        var modal = document.getElementById(trigger.getAttribute("data-modal-target"));
        if (!modal) return;
        lastFocus = trigger;
        modal.hidden = false;
        body.classList.add("modal-open");
        modal.querySelector(".content-modal__close")?.focus();
    };

    trigger.addEventListener("click", open);
    trigger.addEventListener("keydown", function (event) {
        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            open();
        }
    });
});

var closeModal = function () {
    document.querySelectorAll(".content-modal:not([hidden])").forEach(function (modal) {
        modal.hidden = true;
    });
    body.classList.remove("modal-open");
    if (lastFocus) lastFocus.focus();
};
document.addEventListener("click", function (event) {
    if (event.target.closest("[data-modal-close]")) closeModal();
});
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") closeModal();
});

var navLinks = [].slice.call(document.querySelectorAll(".topbar .nav a[href^='#'], .footer .nav a[href^='#']"));
var sections = navLinks.map(function (link) {
    return document.querySelector(link.getAttribute("href"));
}).filter(Boolean);

if ("IntersectionObserver" in window && sections.length) {
    var observer = new IntersectionObserver(function (entries) {
        var visible = entries.filter(function (entry) {
            return entry.isIntersecting;
        }).sort(function (a, b) {
            return b.intersectionRatio - a.intersectionRatio;
        })[0];
        if (!visible) return;

        var id = "#" + visible.target.id;
        navLinks.forEach(function (link) {
            link.classList.toggle("is-active", link.getAttribute("href") === id);
        });
    }, { rootMargin: "-30% 0px -55% 0px", threshold: [.2, .45, .7] });

    sections.forEach(function (section) {
        observer.observe(section);
    });
}
