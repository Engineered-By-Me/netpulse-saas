# NetPulse SaaS - Real-Time Automated Infrastructure & NOC Monitoring Dashboard 🌐

A high-performance **Laravel 12** and **Livewire 3** real-time Network Operations Center (NOC) dashboard designed for automated infrastructure discovery, node status verification, and hardware resource metrics evaluation. Built with strict adherence to MVC architecture, optimized querying, and systems-level shell integrations.

## 🛠️ Technology Stack & Core Architecture

- **Backend Framework:** PHP 8.2+ & Laravel 12 (Expressive decoupled routing profile)
- **Reactive UI Engine:** Livewire 3 (Asynchronous reactive table rows, atomic validations, and zero-refresh polling metrics)
- **Systems Core:** Native OS Shell Interaction (`exec` processing isolated via secure IP validation middleware to block Command Injection vulnerabilities)
- **Database Architecture:** MySQL (Eager Loading implementation via Eloquent relationships to eliminate N+1 query bottlenecks under high-volume resource logs)
- **Automation Pipeline:** Laravel Task Scheduling Engine managing automated continuous background sweeps.

## ✨ System Features

1. **Reactive Node Registry:** Asynchronous asset input layouts ensuring dynamic network device insertion with full validation.
2. **The Live Pinger & Diagnostics:** Leverages systems pings using tailored flags (`-n 1` for Windows / `-c 1` for Unix kernels) to evaluate sub-millisecond round-trip packet deliveries.
3. **Live Streaming Metrics:** Uses Livewire reactive loops (`wire:poll`) to feed real-time hardware data streams directly into the dashboard interface without page refreshes.
4. **Automated Cron Scheduling:** Programmed tasks running silently via `Schedule::call` every minute to autonomously monitor topological connectivity across registered clusters.
5. **Cascading Relational Integrity:** Enforces database ACID consistency using foreign keys with cascading deletions across metrics tables.

## 🚀 Local Installation Guide

1. Clone the repository: `git clone <your-repo-link>`
2. Deploy dependencies: `composer install`
3. Wire your MySQL settings inside a clean `.env` layout.
4. Fire core migrations: `php artisan migrate`
5. Run the background task simulation: `php artisan schedule:work`
6. Boot the environment server: `php artisan serve`
