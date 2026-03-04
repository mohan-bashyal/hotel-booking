# Advanced Hotel Room Booking System

Production-style multi-role hotel booking platform built with Laravel 12. This project demonstrates role-based access control, booking conflict prevention, notification escalation, and clean service-layer organization.

## Project Snapshot

- Domain: Hospitality / Booking Operations
- Stack: Laravel 12, PHP 8.2, MySQL, Tailwind CSS, Vite, Alpine.js
- Architecture: MVC + Service Layer + Role Middleware
- Status: Functional web application (role-based dashboards and booking workflow implemented)

## Why This Project Is Valuable

This project solves a practical operational problem: handling hotel room bookings across multiple internal roles with controlled permissions and clear workflow ownership.

Key engineering outcomes:
- Implemented strict role-based route protection for 4 user types.
- Prevented double-bookings using date-overlap validation logic.
- Designed notification escalation flow (`staff -> admin -> super_admin`) with priority-based action rules.
- Scoped all hotel operations to assigned hotel context for data isolation.

## My Contributions

- Designed and implemented role-based authentication flow and dashboard redirection.
- Built CRUD flows for hotels, admins, staff, room types, and rooms.
- Implemented customer booking flow with availability filtering and booking history.
- Implemented booking status handling for staff and notification acceptance flow.
- Added active/inactive account control for admin and staff login/session access.

## Core Features

### Authentication and Authorization
- Role-aware login (`customer`, `staff`, `admin`, `super_admin`)
- Middleware-enforced access control (`RoleMiddleware`)
- Role-specific route groups and dashboards
- Immediate session invalidation for deactivated staff/admin accounts

### Super Admin Capabilities
- Manage hotels (create, update, delete)
- Manage admin users (create, update, activate/deactivate, delete)

### Admin Capabilities
- Manage room types for assigned hotel
- Manage rooms for assigned hotel
- Manage staff accounts for assigned hotel

### Staff Capabilities
- View bookings in assigned hotel
- Update booking status (`pending`, `confirmed`, `cancelled`)

### Customer Capabilities
- Register/login as customer
- Search available rooms by check-in/check-out date
- Create booking request
- View own booking history

## Booking and Notification Workflow

1. Customer submits booking request.
2. System validates date range and checks overlapping bookings.
3. Booking is created with `pending` status.
4. Notification rows are created by priority:
   - `staff` (priority 1)
   - `admin` (priority 2)
   - `super_admin` (priority 3)
5. Eligible assignee accepts notification.
6. Booking is confirmed and related pending notifications are resolved.

## Technical Design Notes

- Service layer (`app/Services`) keeps controller logic thin.
- Route model binding plus hotel ownership checks prevent cross-hotel unauthorized access.
- Eloquent relationships are used for booking, room, hotel, and user linking.
- Status transition updates are handled consistently for booking + notifications.

## Project Structure

```text
app/
  Http/
    Controllers/
      SuperAdmin/
      Admins/
      Staff/
      Customer/
    Middleware/RoleMiddleware.php
  Models/
  Services/

database/
  migrations/
  seeders/

resources/views/
routes/web.php
```

## Local Setup

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL (or compatible DB)

### Installation

```bash
git clone <your-repo-url>
cd hotel-booking
composer install
npm install
cp .env.example .env
php artisan key:generate
```

### Database

Update `.env` DB credentials, then run:

```bash
php artisan migrate
php artisan db:seed
```

### Run

```bash
php artisan serve
npm run dev
```

Or run combined development services:

```bash
composer run dev
```

## Important Routes

- `/` - welcome
- `/register` - customer registration
- `/login` - generic login
- `/login/superadmin` - super admin login
- `/login/admin` - admin login
- `/login/staff` - staff login
- `/superadmin/dashboard`
- `/admin/dashboard`
- `/staff/dashboard`
- `/customer/rooms`

## Testing

```bash
php artisan test
```

## Suggested Improvements (Next Iterations)

- Add seeders/factories for full demo accounts per role.
- Add feature tests for booking conflict and role restrictions.
- Add email notifications and queue workers for booking events.
- Add audit logs for critical role actions.
- Add CI pipeline (lint, tests, build).

## Recruiter Notes

If you are reviewing this project for a backend/full-stack role, focus on:
- Access control strategy and route/middleware design
- Booking conflict prevention logic
- Notification priority handling
- Separation of concerns (Controller vs Service)

## Author

- Name: `Mohan Bashyal`
- Role: `Laravel / PHP Developer`
- Email: `bashyalmohan77@gmail.com`
- LinkedIn: `https://www.linkedin.com/in/mohan-bashyal/`
- GitHub: `https://github.com/mohan-bashyal/`


## License

MIT
