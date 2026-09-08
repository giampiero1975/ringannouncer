from pathlib import Path
from PIL import Image, ImageChops, ImageEnhance, ImageFilter


ROOT = Path(__file__).resolve().parents[1]
HERO = ROOT / "public/images/ringannouncer/hero-valerio-ai-wide.png"
EDGE = Path(r"C:\Users\giamp\AppData\Local\Temp\codex-clipboard-08a1aef5-986c-4c7b-8877-eeedfaa7e3d7.png")
FALLBACK_EDGE = Path(r"C:\Users\giamp\AppData\Local\Temp\codex-clipboard-08a1aef5-986c-4c7b-9b8d-0028bb2caac1.png")
OUT = ROOT / "public/images/ringannouncer/hero-valerio-ai-wide-baked-edge.png"


def load_edge() -> Image.Image:
    source = EDGE if EDGE.exists() else FALLBACK_EDGE
    edge = Image.open(source).convert("RGBA")

    # Convert black-background previews into real transparency.
    r, g, b, a = edge.split()
    luminance = Image.merge("RGB", (r, g, b)).convert("L")
    alpha_from_light = luminance.point(lambda px: 0 if px < 18 else min(255, int((px - 18) * 1.18)))
    alpha = ImageChops.multiply(a, alpha_from_light)
    alpha = ImageEnhance.Contrast(alpha).enhance(1.25).filter(ImageFilter.GaussianBlur(0.35))

    white = Image.new("RGBA", edge.size, (246, 244, 239, 0))
    white.putalpha(alpha)
    return white


def main() -> None:
    hero = Image.open(HERO).convert("RGBA")
    edge = load_edge()

    target_h = int(hero.height * 0.115)
    target_w = hero.width
    edge = edge.resize((target_w, target_h), Image.Resampling.LANCZOS)

    canvas = hero.copy()
    y = hero.height - target_h + 2
    canvas.alpha_composite(edge, (0, y))
    canvas.convert("RGB").save(OUT, quality=95, optimize=True)

    print(f"created={OUT}")
    print(f"hero_size={hero.size}")
    print(f"edge_size={edge.size}")


if __name__ == "__main__":
    main()
