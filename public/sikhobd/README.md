# 10 Minute School — Modern HTML Site

A complete static HTML/CSS/JS site with:

- **4-level nested menu** (desktop fly-out + mobile collapsible drawer)
- **9 pages**: Home, Courses, Course Detail, About, Contact, Blog, Pricing, **User Dashboard**, Login, Signup
- **Bangla / English language toggle** (BN ⇄ EN, persisted in localStorage)
- **Fully responsive** — desktop, tablet, mobile
- **Modern UI** — glass header, gradient cards, smooth transitions
- Shared header/footer via lightweight JS partials (edit once, applies everywhere)

## File structure

```
10ms-site/
├── index.html
├── courses.html
├── course-detail.html
├── about.html
├── contact.html
├── blog.html
├── pricing.html
├── dashboard.html
├── login.html
├── signup.html
├── css/
│   └── style.css
└── js/
    ├── partials.js   # injects shared header & footer
    └── main.js       # drawer + language toggle + tabs
```

## How to use

1. Open `index.html` in a browser, or drop the whole folder into your project.
2. Edit `js/partials.js` to change the menu / footer in one place.
3. Add or change translations in `js/main.js` inside the `i18n` object.
4. Add a new language? Add a key to `i18n` and a button to the `.lang-switch`.

## Adding a new page

1. Copy any page (e.g. `about.html`) and rename it.
2. Keep the `<div data-include="header"></div>` and `<div data-include="footer"></div>` placeholders.
3. Add `<script src="js/partials.js"></script>` and `<script src="js/main.js"></script>` before `</body>`.

## Adding another menu level

Just nest another `<ul class="dropdown">` inside any `<li class="dropdown-item">` in `js/partials.js` — the CSS handles unlimited depth on desktop, and the mobile drawer's `.m-toggle` works at any depth too.

## Translations

Mark any text with `data-i18n="some.key"` and add the key to both `bn` and `en` dicts in `js/main.js`. Toggle via the BN/EN switch in the header.
