# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**LegendaryClass** is an educational gamification system (Laravel 11 + MongoDB) that transforms classrooms into RPG-style experiences. Students choose character classes (Mago, Guerrero, Ninja, Arquero, Lanzador), earn XP, level up, complete quests, and redeem rewards. Teachers manage classrooms and award behavioral points. Directors oversee the whole institution.

## Common Commands

```bash
# Start development server (alternative to XAMPP Apache)
php artisan serve

# Compile and watch frontend assets
npm run dev

# Production build
npm run build

# Run all tests
php artisan test

# Run a single test
php artisan test --filter TestName

# PHP linting (Laravel Pint)
./vendor/bin/pint

# Interactive REPL
php artisan tinker
```

The project is also accessible via XAMPP at `http://localhost/LegendaryClass/public`.

## Architecture

### Database: MongoDB
All models use MongoDB, **not** a relational DB. Key implications:
- Models extend `MongoDB\Laravel\Eloquent\Model`; `User` extends `MongoDB\Laravel\Auth\User`
- Use `$model->_id` (not `$id`) for MongoDB document IDs
- No traditional migrations for model changes — just update `$fillable` and `$casts`
- Default database: `gamification_edu` (configured via `DB_*` env vars, port 27017)
- Relationships use embedded arrays: `classroom_ids` on User, `student_ids` on Classroom

### Role System
Roles: `director`, `teacher`, `student`, `parent`, `admin`

Routes are guarded with the `role:` middleware alias (maps to `CheckRole`):
```php
Route::middleware(['auth', 'role:teacher,admin'])->group(...)
```
- `director` and `admin` bypass role checks and get full access by default
- `CheckRole` also enforces `is_active` and writes role info to session as `adventurer_class`

### Route Structure
| Prefix | Middleware | Controller namespace |
|--------|-----------|----------------------|
| `/director/*` | `role:director` | `Director\` |
| `/teacher/*` | `role:teacher,admin,profesor` | `Teacher\` |
| `/students/*` | `role:student` | `Student\` |
| `/parent/*` | `role:parent` | `Parent\` |

Classroom routes use slug-based model binding: `{classroom:slug}`.

### Gamification Engine (User model)
- **XP formula**: `level = floor(sqrt(xp / 100)) + 1`
- **Next level XP**: `level² × 100`
- `User::gainExperience($points, $action, $description)` handles XP gain, leveling up, and achievement checks
- Character bonus types (`knowledge`, `strength`, `agility`, `precision`, `creativity`) map to specific action types via `shouldApplyCharacterBonus()`
- Students must select a character before accessing their dashboard (`first_character_selection` flag)

### Key Models
- **User** — all roles share one collection; role-specific logic is branched by `$user->role`
- **Classroom** — belongs to a teacher, has many student IDs; generates slug on create/update
- **StudentBehavior** — records positive/negative behaviors awarded by teachers
- **StudentPoint** — per-classroom point totals (separate from global `points` on User)
- **Reward / StudentReward** — teacher-defined rewards; students purchase with points, teacher approves

### Frontend
- Blade templates + TailwindCSS + AlpineJS (no SPA framework)
- Views organized by role under `resources/views/`: `director/`, `teacher/`, `students/`, `parent/`
- Shared layouts in `resources/views/layouts/`
- Excel import for bulk student creation uses `phpspreadsheet`
