# Ore Restaurant

## Project Description

Ore Restaurant is an online platform for Miss Ore’s restaurant that allows customers to place orders, view menu and their user profile while providing staff with the capability to manage the menu, view orders and change order status. The system aims to facilitate the restaurant's online presence with features for both customers and staff. Users can only place order between 10am - 6pm. This uses JWT for user Authentication.

### Features

- **Staff Features:**
  - Create, delete, and update the food menu.
  - View the list and details of registered customers.
  - View and update the status of orders.
  
- **Customer Features:**
  - View the menu and individual menu items.
  - Place orders.
  - View thie user profile

## Installation Instructions

1. **Clone the Repository:**

   ```bash
   git clone <repository-url>
   cd oreRestaurant
2. **Install Dependencies:**

- Ensure you have Composer installed. Run the following command to install the required PHP packages:
  ```bash
  composer install
3. **Set Up the Environment:**

- Copy the .env.example file to create your .env file:
- Update the .env file with your database and other configuration details.

4. **Generate Application Key:**
   - Generate the application key by running:
     
     ```bash
     php artisan key:generate
5. **Run Migrations:**
   - Apply the migrations to set up the database schema
     ```bash
     php artisan migrate
## Configuration Details
- Database Configuration:
- Update your .env file with your database connection details. Example for MySQL:
    ``` bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ore_restaurant
   DB_USERNAME=root
  DB_PASSWORD=
 
## Usage Instructions
- Authentication:
- Register Customer:
   ```bash
   POST api/register/customer
- Request body
  ```bash
  {
  "first_name": "John",
  "last_name": "Doe",
  "email": "john.doe@example.com",
  "password": "password",
  "password_confirmation": "password"
  }
- Register Staff: 
  ``` bash
     POST api/register/staff
Request Body:
- same as register customer body
- Login:
 -Endpoint:
  ```bash
  POST api/login
  
- Request Body
  
  ```bash
  {
  "email": "john.doe@example.com",
  "password": "password"
  }
Profile
- Get Profile
- Endpoint:
  ```bash
  GET /api/profile
Requires Authentication

## API Endpoints
Authentication Routes
- Register Customer: `POST /api/register/customer`
- Register Staff: `POST /api/register/staff`
- Login: `POST /api/login`

Staff Routes
- Create Menu Item: `POST /api/menus`
- Update Menu Item: `PUT /api/menus/{id}`
- Delete Menu Item: `DELETE /api/menus/{id}`
- List Customers: `GET /api/users`
- Show Customer: `GET /api/users/{id}`
- List Orders: `GET /api/orders`
- Show Order: `GET /api/orders/{id}`
- Update Order Status: `PUT /api/orders/{id}/status`
  
Public Menu Routes
- List Menu Items: `GET /api/menus`
- Show Menu Item: `GET /api/menus/{id}`
- List Discounted Menu Items: `GET /api/menus/list/discounted`
- List Menu Items by Category: `GET /api/menus/category/{category}`

Customer Order Routes
- Place Order: `POST /api/orders`

## Testing Instructions
Postman Setup
1. Import the Postman collection for the API.
2. Test authentication routes with sample data to obtain JWT tokens.
3. Test menu and order management routes with appropriate roles.
  
## Contributing Guidelines
Admin Management
- Implement an admin system to ensure staff are registered by an authenticated admin.
Enhancement
- Suggest and implement improvements to the API.
- Update documentation as needed.

## Licenses
- Laravel: Licensed under the MIT License.
- JWT Authentication: Licensed under the MIT License.

## Additional Information
- Operational Hours Middleware: Ensure that routes requiring specific operational hours are protected by middleware.
- Role Middleware: Implement role-based access control to restrict access based on user roles.

  







