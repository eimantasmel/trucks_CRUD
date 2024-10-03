# Truck Management System

This Laravel project provides a management system for trucks, enabling CRUD operations and the assignment of subunits for temporary replacements.

## Features
![Alt text](https://i.postimg.cc/bJ6RB3rv/image.png)

![Alt text](https://i.postimg.cc/wBx92hBw/image.png)

![Alt text](https://i.postimg.cc/ZRgfw4wR/image.png)

![Alt text](https://i.postimg.cc/qRrcRWhq/image.png)

### 1. Truck CRUD
- **Fields:**
  - `Unit number` (`string`, required): A unique identifier for the truck (e.g., `A1578`, `8050`).
  - `Year` (`integer`, required): The year of the truck's first registration (allowed values from `1900` up to `+5 years` from the current year).
  - `Notes` (`text`, optional): Free-form comments about the truck (e.g., "Available for rent").

### 2. TruckSubunit Assignment
- **Subunit**: A truck can act as a replacement (subunit) for another truck.
- **Fields:**
  - `main_truck_id`: The ID of the truck being replaced.
  - `subunit_truck_id`: The ID of the truck replacing the main truck.
  - `start_date`: The date when the TruckSubunit starts.
  - `end_date`: The date when the TruckSubunit ends.

### 3. Validation Rules
- A truck cannot be assigned as a TruckSubunit to itself.
- Truck Subunit date ranges cannot overlap for the same truck.
- If a truck is already a TruckSubunit for another truck, it cannot be assigned a TruckSubunit during the same period.

## Technical Requirements
- Built using **Laravel** (latest version).
- Clean and simple code, adhering to Laravel conventions.

## Project Setup
1. Clone the repository.
2. Run `composer install` to install dependencies.
3. Set up .env file
4. Run database migrations using `php artisan migrate`.
5. Run automated tests using `php artisan serve`.
5. Start the development server using `php artisan serve`.

