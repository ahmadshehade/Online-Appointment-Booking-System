# Online Appointment Booking System

A fully integrated online appointment booking system built with **Laravel 12** and **MySQL**, connecting clients with service providers, managing bookings, services, availability, payments, reviews, coupons, and notifications.

---

## 1️⃣ Project Summary

This project provides a complete solution for online appointment booking.  

- Clients can book appointments, make payments, and rate services.  
- Service providers manage their profile, services, and availability.  
- Admins monitor the system, manage users, providers, and content.

---

## 2️⃣ Main Objectives

- Enable clients to easily book appointments with service providers.
- Manage service providers, their services, and available time slots.
- Track appointment status: pending, confirmed, or canceled.
- Allow clients to rate services and write reviews.
- Apply coupons and discounts to services or appointments.
- Send notifications when a booking is created or updated.
- Support online payments.

---

## 3️⃣ System Actors

| Role | Description |
|------|------------|
| Client | Books appointments, makes payments, writes reviews. |
| Service Provider | Manages profile, services, and availability. |
| Admin | Monitors the system, manages users, service providers, content, and settings. |

---

## 4️⃣ Main Database Tables & Relationships

| Table Name | Description | Key Relationships |
|------------|------------|-----------------|
| users | System users (clients, providers, admins) | `role` determines user type |
| service_providers | Service providers | Linked to `users` (`user_id`) |
| availability_slots | Time slots for providers | Linked to `service_providers` (`service_provider_id`) |
| services | Services offered by providers | Linked to `service_providers` (`service_provider_id`), optionally `coupons` |
| appointments | Bookings | Linked to `services`, `users` (`client_id`), `availability_slots`, optionally `coupons` |
| coupons | Coupons and discounts | Can be linked to `services` or `appointments` |
| reviews | Service reviews | Linked to `service_providers` and `users` |
| notifications | System notifications | Linked to `users` |
| payments | Payments for services | Linked to `appointments` |

---

## 5️⃣ Entity Relationship Diagram (ERD)

```text
users
├─ id (PK)
├─ name
├─ email
├─ password
└─ role (client/provider/admin)

service_providers
├─ id (PK)
├─ user_id (FK → users.id)
└─ profile info

availability_slots
├─ id (PK)
├─ service_provider_id (FK → service_providers.id)
├─ date
└─ time_slot

services
├─ id (PK)
├─ service_provider_id (FK → service_providers.id)
├─ name
├─ description
└─ price

appointments
├─ id (PK)
├─ service_id (FK → services.id)
├─ user_id (FK → users.id)
├─ availability_slot_id (FK → availability_slots.id)
├─ coupon_id (optional FK → coupons.id)
└─ status (pending/confirmed/canceled)

coupons
├─ id (PK)
├─ code
├─ discount
├─ service_id (optional FK → services.id)
└─ expires_at

reviews
├─ id (PK)
├─ service_provider_id (FK → service_providers.id)
├─ user_id (FK → users.id)
├─ rating
└─ comment

notifications
├─ id (PK)
├─ user_id (FK → users.id)
├─ message
└─ read_at

payments
├─ id (PK)
├─ appointment_id (FK → appointments.id)
├─ amount
├─ status
└─ payment_method

Notes:

- PK = Primary Key  
- FK = Foreign Key
