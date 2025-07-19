# Modern Admin ReCAPTCHA v3

A modern YOURLS plugin that adds **Google reCAPTCHA v3** protection to the admin login screen, using behavioral scoring to stop bots and spammy login attempts — with no user interaction required.

## ✨ Features

* Invisible reCAPTCHA v3 integration (no checkboxes or puzzles)
* Blocks suspicious or low-trust login attempts
* Works silently in the background
* Fully self-contained — no bundled libraries
* Easy to install and configure

## 🔧 Requirements

* [YOURLS](https://yourls.org) `v1.10+`
* PHP `8.1+` recommended
* A reCAPTCHA v3 key pair from [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin)

---

## 🚀 Installation

1. **Download or clone** this repository into the YOURLS plugin directory:

   ```bash
   cd yourls/user/plugins
   git clone https://github.com/farshad-sadri/modern-admin-recaptcha-v3.git

Or [download as ZIP](https://github.com/farshad-sadri/modern-admin-recaptcha-v3/archive/refs/heads/master.zip) and extract it to:

```
/user/plugins/modern-admin-recaptcha-v3
```

2. **Activate the plugin** from the YOURLS admin dashboard:
   `http://your-short-domain/admin/plugins.php`

3. **Configure reCAPTCHA v3 keys:**

   * Go to the plugin settings page (`Plugins → Modern ReCAPTCHA Settings`)
   * Enter your reCAPTCHA v3 **site key** and **secret key**
   * Save the changes

---

## ⚙️ How It Works

* When a user visits the login page, the plugin silently collects a **reCAPTCHA token**.

* The token is sent to Google for verification.

* If the response has:

  * `success = true`
  * `score >= 0.5`
  * `action = 'admin_login'`

  Then the login proceeds.

* Otherwise, login is **blocked with an error** — effectively stopping spam or bot traffic.

---

## 📜 License

[MIT License](LICENSE)

---

## 🤝 Contributions

Feedback and pull requests are welcome! If you encounter a bug or have a feature idea, feel free to [open an issue](https://github.com/farshad-sadri/modern-admin-recaptcha-v3/issues).

---

## 👨‍💻 About the Author

**Farshad Sadri** is a design technologist and product strategist with over 25 years of experience crafting human-centered digital experiences. He leads cross-functional initiatives at the intersection of product design, frontend development, and emerging tech — including AI, Web3, and creative automation.

Farshad is also the founder of [Dash Squid](https://dashsquid.com), a design studio helping companies build memorable brands and scalable digital products.

* Portfolio: [farshadsadri.com](https://farshadsadri.com)
* GitHub: [@farshad-sadri](https://github.com/farshad-sadri)
* LinkedIn: [linkedin.com/in/farshadsadri](https://www.linkedin.com/in/farshadsadri)

