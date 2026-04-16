# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**DAnoxiaD** is a CodeIgniter 4.7 application (PHP 8.4) running in a DDEV Docker environment on Ubuntu/WSL2. The application code lives in the `anoxia/` subdirectory; the repo root contains only DDEV config and this file.

- Local URL: `http://anoxia.ddev.site`
- Database: MariaDB 11.8 (via DDEV)
- Webserver: Apache FPM

## Common Commands

All commands run from `anoxia/` (or via `ddev exec` from the repo root).

```bash
# Start/stop DDEV environment
ddev start
ddev stop

# Run migrations
ddev exec php spark migrate

# Run database seeders
ddev exec php spark db:seed <SeederName>

# Run all tests
ddev exec composer test
# or directly
ddev exec ./vendor/bin/phpunit

# Run tests in a specific directory
ddev exec ./vendor/bin/phpunit tests/unit

# Generate code coverage
ddev exec ./vendor/bin/phpunit --colors --coverage-text=tests/coverage.txt --coverage-html=tests/coverage/ -d memory_limit=1024m

# CodeIgniter CLI (spark) — list all commands
ddev exec php spark list
```

## Architecture

### Request Flow

```
Browser → anoxia/public/index.php → app/Config/Routes.php → Controller → View
```

### Directory Layout (inside `anoxia/`)

| Path | Purpose |
|---|---|
| `app/Controllers/` | HTTP controllers extending `BaseController` |
| `app/Models/` | Database models using CI4's ORM |
| `app/Views/` | PHP view templates; `partials/` for shared fragments |
| `app/Config/Routes.php` | All route definitions |
| `app/Config/` | 40+ CI4 config files (App, Database, Services, etc.) |
| `app/Database/Migrations/` | Schema migrations |
| `app/Database/Seeds/` | Seeders for test/dev data |
| `tests/` | PHPUnit test suites (`unit/`, `database/`, `session/`) |
| `writable/` | Runtime data: cache, logs, sessions, uploads |

### Route Map & Controllers

**Public routes** (no auth required):
| Route | Controller::Method | Purpose |
|---|---|---|
| `GET /login` | `Auth::showLogin` | Login page |
| `POST /auth/login` | `Auth::login` | Authenticate (email/password, optional remember-me) |
| `POST /auth/recover` | `Auth::recoverPassword` | Send password reset email |
| `GET /auth/reset-password` | `Auth::resetPassword` | Show reset form (token-based) |
| `POST /auth/reset-password` | `Auth::resetPassword` | Process password reset |
| `GET /dashboardtest` | `UserManager::index` | Admin dashboard (test route) |
| `GET /campaigntest` | `CampaignManager::index` | Campaign list (test route) |
| `POST /admin/users/create` | `UserManager::create` | Create pending user + send setup email |
| `POST /campaigns/create` | `CampaignManager::create` | Create campaign with DM assignment |
| `GET /uploads/(:any)` | `Uploads::show` | Serve uploaded files (path-traversal protected) |

**Auth-protected routes** (via `AuthFilter`):
| Route | Controller::Method | Purpose |
|---|---|---|
| `GET /` | `Home::index` | Dashboard with user counts + recent campaigns |
| `GET /auth/logout` | `Auth::logout` | Destroy session + remove remember-me tokens |
| `POST /settings/theme` | `Settings::updateTheme` | Change theme (medieval/white/dark/carbonfox/ember) |
| `GET /personagens` | `PersonagemManager::index` | List character sheets |
| `POST /personagens/create` | `PersonagemManager::create` | Create character sheet |

**Additional Settings methods** (not yet routed):
- `Settings::characterSheet()` — Display ability score config page
- `Settings::updateCharacterSheet()` — Update ability score labels/order

### Data Model

| Table | Key Columns | Notes |
|---|---|---|
| `users` | id, name, email, password_hash, is_admin, is_active, theme | theme default: 'medieval' |
| `password_resets` | id, user_id, token, expires_at | FK → users (CASCADE) |
| `campaign` | id, name, description, img_path, is_active | |
| `user_campaign` | user_id, campaign_id, is_dm | Join table; CASCADE FKs to both |
| `personagens` | id, campaign_id, character_name, player_name, race, class, level, background, hp_current, hp_max, ability_scores (JSON), notes | FK → campaign (CASCADE) |
| `ability_score_config` | id, score_key, label, abbr, sort_order | Seeds 6 PT-BR D&D abilities |

**Relationships**: Users ↔ Campaigns (many-to-many via user_campaign, is_dm flag). Campaign → Personagens (one-to-many).

### Key Conventions

- **Base URL** is set in `app/Config/App.php` — currently `http://localhost:8080/`; DDEV overrides this via environment.
- **Database credentials** are empty in `app/Config/Database.php`; real values go in `.env` (git-ignored).
- Controllers extend `BaseController` which initialises `$this->request`, `$this->response`, and `$this->logger`.
- `BaseController::initController()` also checks for remember-me tokens to restore sessions.
- CI4's `spark` CLI (at `anoxia/spark`) is used for all code generation (`make:controller`, `make:model`, `make:migration`, etc.).
- **AuthFilter** checks `session()->get('logged_in')` and redirects to `/login` if false.
- **Sessions**: FileHandler driver, 1-hour expiration.
- **Logging**: Uses `log_message('debug', '[TAG] message', $context)` with bracket-delimited tags like `[AUTH]`, `[AUTH_FILTER]`.
- **Views**: `pages/` for full pages, `modals/` for modal dialogs, `partials/` for reusable fragments. Main layout is `app.php` + `theme_war_room.php`.
- **Uploads**: Stored in `writable/uploads/`, served via `Uploads::show()` with MIME detection.
- **CharacterSheet config**: `Config/CharacterSheet.php` holds defaults but the `ability_score_config` DB table is authoritative at runtime.
- **Themes**: medieval (default), white, dark, carbonfox, ember.

### Current Application State

Active development. Features implemented so far:
- Authentication (login, registration, password recovery, remember-me tokens)
- User creation and management (admin creates pending users, sends setup email)
- Campaigns (create with DM assignment, search/filter/paginate, image uploads)
- Character sheets (personagens) with D&D ability scores (PT-BR labels)
- Admin dashboard with user/DM counts
- Theme customization (5 themes)
- Configurable ability score system