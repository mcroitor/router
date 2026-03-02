# Changelog

## [Unreleased]

### Added

- Added Unlicense (`UNLICENSE`) to the project.
- Planned middleware pipeline hooks (pre-handler / post-handler).
- Planned optional OpenAPI schema generation for registered routes.

### Changed

- Added SPDX license notation (`Unlicense`) to project documentation.
- Planned API polish for next release: align response helper signatures and examples across docs/tests.
- Planned cleanup of REST/legacy route listing behavior in diagnostics (`getRoutes()` for method routes).

### Fixed

- Planned compatibility hardening for edge SAPIs around request body/query extraction.

## [v1.1.0] - 2026-03-03

REST API support (Phases 1–4)

### Added

- HTTP method-aware routing (`GET`, `POST`, `PUT`, `PATCH`, `DELETE`, `OPTIONS`) via:
  - `Router::match(array $methods, string $path, callable $handler)`
  - `Router::get/post/put/patch/delete/options(...)`
- Path normalization and dispatch by `REQUEST_METHOD + REQUEST_URI`.
- Template routes with named params, e.g. `/api/users/{id}`.
- Request helpers:
  - `Router::getPathParams(): array`
  - `Router::getQueryParams(): array`
  - `Router::getBody(): array`
- JSON response helper:
  - `Router::json($data, int $status = 200): string`
- JSON error payloads for REST mode:
  - `404 Not Found`
  - `405 Method Not Allowed` (+ `Allow` header)
- Attribute-based REST metadata support:
  - `#[Route('/api/users/{id}', methods: ['GET'])]`

### Changed

- `register(string $route, callable $handler)` remains and maps to `GET` for backward compatibility.
- Reflection registration now reads `Route` attribute instance (`path`, `methods`) and registers methods accordingly.
- Legacy attribute routes (`#[Route('about')]`) remain compatible with `?q=` mode.

### Compatibility

- Legacy query routing still works:
  - `?q=about`
  - `?q=user/view/11`
- Existing test scripts `test.php`, `test01.php`, `test02.php` continue to run.

### Tests and examples

- Added REST test scripts:
  - `tests/test03.php` — method-based routes + 404/405 behavior
  - `tests/test04.php` — template params + body parsing
  - `tests/test05.php` — attribute-based REST routes
- Updated `README.md` with:
  - REST examples (Phase 1–3)
  - migration notes
  - current interface summary

### Main touched files

- `src/mc/router.php`
- `src/mc/route.php`
- `tests/test03.php`
- `tests/test04.php`
- `tests/test05.php`
- `README.md`
- `TODO.md`
