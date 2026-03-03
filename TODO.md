# TODO — REST API support for `router`

## Goal

Add REST API routing with HTTP method awareness while keeping backward compatibility for existing GET `q`-based routes.

## Phase 1 — Core REST routing (MVP)

- [x] Extend route storage from `path => handler` to `method + path => handler`.
- [x] Keep `register(string $route, callable $handler)` as backward-compatible alias for `GET`.
- [x] Add REST helpers in `Router`:
  - [x] `get(string $path, callable $handler)`
  - [x] `post(string $path, callable $handler)`
  - [x] `put(string $path, callable $handler)`
  - [x] `patch(string $path, callable $handler)`
  - [x] `delete(string $path, callable $handler)`
  - [x] `options(string $path, callable $handler)`
  - [x] `match(array $methods, string $path, callable $handler)`
- [x] Resolve request path from `REQUEST_URI` (with fallback to `q` param).
- [x] Normalize incoming path (`/api/users/1`, trailing slash handling).
- [x] Update `run()` to route by method + path.
- [x] Return proper statuses:
  - [x] `404 Not Found` when path does not exist
  - [x] `405 Method Not Allowed` when path exists for other methods
  - [x] `Allow` header for 405 responses
- [x] Add / update tests for method-based dispatch and 404/405 behavior.

### Done criteria (Phase 1)

- Existing tests continue to work for legacy `q` routes.
- New method-based routes can be registered and dispatched.
- 404/405 behavior is deterministic and covered by tests.

---

## Phase 2 — Path params + request body + JSON responses

- [x] Add route templates with named params, e.g. `/users/{id}`.
- [x] Implement template matcher + param extraction into handler input.
- [x] Add request body parsing helpers:
  - [x] `application/json`
  - [x] `application/x-www-form-urlencoded`
- [x] Add response helper: `json(array|object $data, int $status = 200): void`.
- [x] Define default error payload format for API errors.
- [x] Add / update tests for template matching and body parsing.

### Done criteria (Phase 2)

- Handlers can access path params and parsed body.
- JSON responses have consistent shape and status codes.

---

## Phase 3 — Attribute support for REST metadata

- [x] Extend `#[Route]` attribute to accept methods, e.g. `#[Route('users/{id}', methods: ['GET'])]`.
- [x] Keep old attribute usage valid (`#[Route('about')]` => `GET`).
- [x] Update reflection registration in `Router::scan_*` to read methods metadata.
- [x] Add tests using attribute-based REST routes.

### Done criteria (Phase 3)

- Attribute-based routes can declare one or more HTTP methods.
- Legacy attribute declarations still work unchanged.

---

## Phase 4 — Docs + examples

- [x] Update README: REST routing section, migration notes, examples.
- [x] Add examples for:
  - [x] CRUD-style routes (`GET/POST/PUT/PATCH/DELETE`)
  - [x] Path params (`/users/{id}`)
  - [x] JSON request/response
  - [x] Backward compatibility mode (`?q=`)
- [x] Update test instructions if needed.

### Done criteria (Phase 4)

- README documents both legacy and REST usage clearly.
- New users can run an API example end-to-end.

---

## Non-goals (for now)

- [ ] No full middleware pipeline framework.
- [ ] No DI container / controller auto-wiring.
- [ ] No OpenAPI generation in initial implementation.

---

## Suggested implementation order

1. Phase 1 (routing core + compatibility)
2. Phase 2 (templates/body/json)
3. Phase 3 (attribute methods)
4. Phase 4 (documentation)
