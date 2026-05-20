# Real Estate Database Web App — PHP, MySQL

A web application for browsing, listing, and managing real estate properties. Users can view a paginated list of houses with full details — address, rooms, price, owner, and features — and perform create, update, and delete operations through an HTML form interface backed by a MySQL database.

Built from scratch in PHP using PDO. The backend connects to a relational MySQL database with ten normalised tables (House, Address, FeatureCategory, Feature, HouseFeature, Person, Agent, Owner, HouseForSale, Sale) linked through foreign keys with ON DELETE CASCADE rules. Insert and update operations run inside PDO transactions to ensure all related rows (house, address, features, owner) are written atomically or rolled back together. A Python script (`data.py`) generates synthetic test data using parameterised INSERT statements. `htmlspecialchars()` is applied to all rendered output to prevent XSS.

---

## Use Cases
- Property listing platforms: the multi-table schema covers the core data model of a real estate marketplace — properties, addresses, features, pricing history, and ownership
- Inventory management systems: the same CRUD-over-relational-data pattern (paginated table, inline edit/delete, transactional inserts) applies to any backend admin tool managing structured records
- Database course projects: demonstrates how to design a normalised schema, write multi-table JOINs, use PDO transactions, and build form-driven CRUD pages in PHP
- CMS admin panels: the architecture (form → PHP controller → SQL → redirect) is the foundation of traditional PHP web apps and CMS backends like older WordPress or Drupal installations

## Challenges
- **Transaction atomicity across tables**: inserting a new house listing requires writing to House, Address, HouseFeature, and Owner in a single atomic operation — if any step fails, all must be rolled back; wrapping these in `pdo->beginTransaction()` / `commit()` with a `rollBack()` on exception handles this correctly
- **Multi-table JOIN correctness**: the main listing query joins House with Address, HouseForSale, and Owner using LEFT JOINs — using INNER JOIN would silently drop houses with no price or no owner, requiring careful choice of join type to match the application semantics
- **Pagination with fence-post off-by-one**: fetching `rowsPerPage + 1` rows and checking whether that extra row exists is the standard trick for detecting whether a "next page" button should render, without running a separate COUNT query
- **Feature assignment in a many-to-many table**: HouseFeature links each house to zero or many features from a separate Feature/FeatureCategory hierarchy; on update, the safest approach is to DELETE all existing HouseFeature rows for the house and re-INSERT from the submitted checkbox values, avoiding partial-update inconsistencies

---

## Schema

```
House ──< Address            (one house, one address)
House ──< HouseFeature >── Feature ──< FeatureCategory
House ──< HouseForSale ──< Sale
House ──< Owner >── Person
Person ── Agent
```

Ten tables with foreign key constraints and ON DELETE CASCADE rules throughout.

---

## Tech Stack

| Item | Detail |
|---|---|
| Language | PHP |
| Database | MySQL |
| DB Access | PDO (prepared-statement capable connection layer) |
| Data Generator | Python (`data.py`) |
| Frontend | Plain HTML forms |
| Libraries | None |

---

## Project Structure

```
Real-Estate-Database-Web-App/
├── src/
│   ├── houses.sql           ← full schema (10 tables)
│   ├── houses-base.sql      ← base seed data
│   ├── houses-data.sql      ← generated test data
│   ├── houses-select.sql    ← reference SELECT queries
│   ├── db.php               ← PDO connection
│   ├── start.php            ← main page: paginated listing + insert form
│   ├── insert.php           ← transactional insert (House+Address+Features+Owner)
│   ├── update.php           ← transactional update
│   ├── delete.php           ← delete house (cascades via FK)
│   └── data.py              ← Python test data generator
└── results/
    └── screen-capture.webm  ← live demo recording
```

---

## Run

**Requirements:** PHP, MySQL.

```bash
# Import schema and seed data
mysql -u root -p houses < src/houses.sql
mysql -u root -p houses < src/houses-base.sql
mysql -u root -p houses < src/houses-data.sql

# Update credentials in src/db.php, then serve
php -S localhost:8000 -t src/
# Open http://localhost:8000/start.php
```

---

## Course

TBD  
The Pennsylvania State University
