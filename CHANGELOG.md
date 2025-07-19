# Changelog

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0] - 2025-07-19

### Added
- Initial release of **Modern Admin ReCAPTCHA v3** for YOURLS.
- Full upgrade from reCAPTCHA v2 to reCAPTCHA v3 for invisible spam protection.
- Admin login form integration with Google’s latest reCAPTCHA API.
- Custom score threshold option for determining bot behavior.
- Graceful fallback and message display on suspicious activity.
- Lightweight plugin structure compatible with YOURLS 1.10+.

### Changed
- Complete rewrite of original `Admin NoReCAPTCHA` plugin.
- Switched from user-interrupting challenge (v2) to invisible scoring model (v3).
- Security logic modernized to follow current best practices in bot detection.

---

## Planned

### Upcoming
- Admin panel settings page for score threshold and site key configuration.
- Logging system to monitor reCAPTCHA scores and responses.
- Multi-language support.

---

