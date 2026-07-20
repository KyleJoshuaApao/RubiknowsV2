# RubiKnows — Design System & Visual Identity

## 1. Brand Philosophy

RubiKnows is a world-class engineering firm where precision, structural integrity, and technical excellence converge. The digital presence reflects these values through a clean, professional visual language built on a white canvas with bold black typography and warm orange/gold accents that convey energy, innovation, and authority.

**Core Principles:**
- **Precision** — Every pixel, every spacing unit, every typographic choice is intentional.
- **Clarity** — Information hierarchy is paramount. No ambiguity.
- **Warmth** — Orange/gold accents humanize the technical precision, suggesting approachability and innovation.
- **Structural Integrity** — The design itself feels engineered, with grid-based layouts and measured proportions.
- **Innovation** — Forward-thinking through sophisticated motion, micro-interactions, and depth.

---

## 2. Color Palette

### Primary Colors
| Token | Hex | Usage |
|-------|-----|-------|
| `brand` (DEFAULT) | `#E07B2A` | Primary brand accent, CTAs, active states |
| `brand-50` | `#FDF3EB` | Light tint backgrounds |
| `brand-100` | `#FBE8D8` | Subtle tint backgrounds, glows |
| `brand-200` | `#F5C9A1` | Borders, dividers, soft accents |
| `brand-300` | `#EFA46A` | Hover states, secondary accents |
| `brand-400` | `#E88933` | Hover states, warm accents |
| `brand-500` | `#E07B2A` | Primary accent, links, buttons |
| `brand-600` | `#C76A20` | Hover states, darker accent |
| `brand-700` | `#A35218` | Deep accent, dark sections |
| `brand-800` | `#7F3D10` | Very deep accent |
| `brand-900` | `#5C2A0A` | Near-black warm surfaces, dark footer |
| `black` | `#000000` | Primary text, headings |
| `white` | `#FFFFFF` | Backgrounds, cards, negative space |
| `gray-50` | `#fafafa` | Ultra-light section backgrounds |
| `gray-100` | `#f5f5f5` | Alternating sections |
| `gray-200` | `#e5e5e5` | Light borders |
| `gray-300` | `#a3a3a3` | Muted borders |
| `gray-400` | `#737373` | Secondary text |
| `gray-500` | `#404040` | Body text |

### Accent System
- **Primary Accent:** `#E07B2A` (warm orange) — used for CTAs, active states, links, hover effects
- **Gold Accent:** `#FFC30B` — used sparingly for premium highlights, preloader, and special emphasis
- **Neutral Foundation:** White backgrounds with black typography provide the clean canvas
- **Depth Creation:** Orange glows, borders, and opacity layers create visual hierarchy

---

## 3. Typography

### Type Scale
| Role | Class | Size | Weight | Line Height | Tracking |
|------|-------|------|--------|-------------|----------|
| Display | `text-display` | 5rem–7rem | 800–900 | 0.95 | -0.02em |
| H1 | `text-h1` | 3.5rem–5rem | 800 | 1.05 | -0.01em |
| H2 | `text-h2` | 2.5rem–3.5rem | 700–800 | 1.1 | -0.01em |
| H3 | `text-h3` | 1.75rem–2.25rem | 700 | 1.2 | 0 |
| H4 | `text-h4` | 1.25rem–1.5rem | 600 | 1.4 | 0 |
| Body Large | `text-body-lg` | 1.125rem–1.25rem | 400 | 1.7 | 0 |
| Body | `text-body` | 1rem | 400 | 1.7 | 0 |
| Caption | `text-caption` | 0.75rem–0.875rem | 500 | 1.5 | 0.05em |
| Mono | `text-mono` | 0.75rem–0.875rem | 500 | 1.5 | 0.08em |

### Font Families
- **Sans-Serif (Primary):** `Inter` — Used for all UI elements, body text, navigation. Clean, highly legible, modern.
- **Serif (Display):** `Playfair Display` or `Roboto Slab` — Used exclusively for H1/H2 headlines to convey authority and sophistication. Creates elegant contrast with the geometric sans-serif body.
- **Monospace:** `JetBrains Mono` or `IBM Plex Mono` — Used for technical annotations, labels, code-like elements, section numbers.

---

## 4. Layout & Spacing

### Grid System
- **Container Max Width:** `1280px` (7xl) — Feels contained and focused.
- **Grid Columns:** 12-column grid for complex layouts; 4-column for cards.
- **Gutter:** `24px` (6) on mobile, `32px` (8) on tablet, `48px` (12) on desktop.

### Spacing Scale
Based on an 8px base unit. All margins, padding, and gaps use multiples of 8.

| Token | Value |
|-------|-------|
| `space-1` | 4px |
| `space-2` | 8px |
| `space-3` | 12px |
| `space-4` | 16px |
| `space-6` | 24px |
| `space-8` | 32px |
| `space-12` | 48px |
| `space-16` | 64px |
| `space-24` | 96px |
| `space-32` | 128px |

---

## 5. Component Architecture

### Buttons
| Variant | Style | Usage |
|---------|-------|-------|
| **Primary** | Orange bg (`#E07B2A`), white text, orange border | Main CTAs |
| **Secondary** | White bg, black text, 1px black border | Secondary actions |
| **Ghost** | Transparent bg, orange text, no border | Tertiary actions, nav links |
| **Outline Bold** | Transparent bg, 2px orange border, orange text | Feature highlights |

All buttons use `border-radius: 9999px` (fully rounded) except where sharp edges are explicitly desired for technical drawings.

### Cards
- **Background:** White or near-white (`#fafafa`)
- **Border:** 1px solid `#e5e5e5`
- **Border Radius:** `24px` (rounded-3xl) for softness, or `0px` for technical precision
- **Shadow:** No drop shadows. Depth is created through:
  - Orange border on hover
  - Subtle lift (`-translate-y-2`) on hover
  - Orange glow shadows

### Section Dividers
- Thin 1px orange lines (`border-brand-200`) between major sections
- Alternating white/off-white backgrounds to create visual rhythm

---

## 6. Visual Depth & Engineering Aesthetic

### Grid & Blueprint Patterns
- Subtle 60px grid overlays at 3%–5% opacity
- Used on hero sections and CTA backgrounds to evoke technical drawings
- Grid lines are `#000000` at very low opacity

### Technical Annotations
- Section numbers (`01`, `02`, `03`) in monospace font, preceded by a small orange dot
- Labels like `FIG. 1.2`, `SCALE 1:1`, `REF: RUBI-ENG-2026` in small caps, monospace
- Coordinate markers or rulers as decorative elements

### Line Work
- Thin orange lines (1px) used as separators, accent bars, and directional cues
- Lines animate from 0 width to full width on scroll for dynamic feel

### Negative Space
- Generous padding between sections (`py-24` to `py-32`)
- White space is an active design element, not just empty space
- Creates breathing room and emphasizes content hierarchy

### Orange Accents
- Orange glows (`bg-brand-500/10`) create ambient warmth
- Orange borders on hover provide interactive feedback
- Orange dots in badges and technical markers reinforce brand identity

---

## 7. Motion & Interaction

### Principles
- **Purposeful motion:** Every animation serves a functional or aesthetic purpose.
- **Easing:** `cubic-bezier(0.16, 1, 0.3, 1)` — snappy, professional feel.
- **Duration:** 300ms–700ms for UI transitions. 1s+ for scroll-driven reveals.

### Scroll Animations
- Elements fade up and translate into view (`fadeInUp`)
- Stagger delays for card grids (`0.1s` increments)
- No bouncy or playful easing — keep it engineered and precise

### Hover States
- **Links:** Underline grows from center
- **Cards:** Subtle lift (`-translate-y-1`) with border darkening
- **Buttons:** Scale `1.02` or color inversion

---

## 8. Page Architecture

### Homepage
1. **Hero** — Full-viewport-height, black text on white. Giant serif headline with orange italic accent. Technical grid overlay. Orange CTA button.
2. **Stats Bar** — Horizontal dark strip with white text and orange accents. Animated counters for projects, years, clients.
3. **Services Grid** — 3-column cards on white. Orange top accent bar on hover. Icon + number + title + description.
4. **Featured Projects** — Large imagery with minimal text overlay. Orange border on hover. Grayscale to color transition.
5. **Engineering Process** — Numbered timeline showing methodology. 01, 02, 03, 04 with connecting line.
6. **Testimonials** — Clean cards with large quotation marks in orange.
7. **CTA Strip** — Full-width dark background, white text, orange button, centered message.
8. **Footer** — Dark background, white text, orange logo accent and social icons.

### Services Page
- Header with large serif title and orange italic accent
- Grid of service cards with animated orange top bar
- Each card has: monospace number badge, icon, title, description, inquiry button
- CTA banner at bottom with orange button

### Projects / Portfolio
- Grid layout with orange hover borders
- Large imagery with minimal UI
- Grayscale to color on hover
- Each project card: image, title, location, status badge, details link

### Project Details
- Large hero image at top with dark overlay
- Project metadata in a technical sidebar
- Orange CTA button for inquiries

### About Us
- Company stats with orange left border accents
- Mission/Vision in a bordered frame with orange corner accents
- Leadership grid with orange hover effects

### Contact
- Split layout: form on left, contact info + map on right
- Orange tab accents for General Inquiry / Quotation
- Orange form focus states and submit buttons

### Gallery
- Square grid with orange hover borders
- Dark overlay with orange category text on hover
- Orange lightbox accents

### Careers
- Job listing cards with orange hover borders
- Orange Apply Now buttons
- Orange application form header

---

## 9. Imagery & Iconography

### Photography
- High-contrast, desaturated images
- Architectural, structural, and human elements
- Consistent aspect ratios (4:3 or 16:9)
- Orange accent treatment on hover or as subtle overlay

### Icons
- Line icons only (no filled icons)
- 2px stroke weight
- Orange color for brand icons, black for utility icons
- Geometric and precise

---

## 10. Responsive Behavior

| Breakpoint | Range | Adjustments |
|------------|-------|-------------|
| Mobile | < 640px | Single column, reduced type scale, stacked layouts |
| Tablet | 640px–1024px | 2-column grids, medium type scale |
| Desktop | > 1024px | Full 3-4 column grids, large type scale, generous whitespace |

Navigation collapses to hamburger menu on mobile. All touch targets are minimum 44px.

---

## 11. Technical Notes

- **Framework:** Laravel Blade with Tailwind CSS
- **Animations:** Alpine.js + Intersect plugin for scroll reveals
- **Font Loading:** Bunny.net CDN for Inter, Playfair Display, and JetBrains Mono
- **Preloader:** Minimalist — dark screen, orange percentage counter and progress bar
- **Accessibility:** WCAG 2.1 AA compliant. Minimum contrast ratio 4.5:1 for body text, 3:1 for large text.
