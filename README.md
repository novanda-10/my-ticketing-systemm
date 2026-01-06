## ✨ Features

User Management

Create, update, replace, delete users

Role-based access: Manager vs Normal User

Ticket Management

Create, update, replace, delete tickets

Assign tickets to specific authors

Authentication

Login / Logout with API tokens via Sanctum

Authorization

Token-based abilities using Policies and Abilities class

JSON:API Responses

Standardized output with attributes, relationships, includes, and links

## 🔑 Authentication

Login: POST /api/login

Required: email, password

Logout: POST /api/logout (requires auth)

Tokens have abilities defined in App\Permissions\Abilities

## 🛣️ API Endpoints

👤 Users

| Method | Endpoint          | Description             |
| ------ | ----------------- | ----------------------- |
| GET    | `/api/users`      | List all users          |
| POST   | `/api/users`      | Create a new user       |
| GET    | `/api/users/{id}` | Show user details       |
| PATCH  | `/api/users/{id}` | Update user partially   |
| PUT    | `/api/users/{id}` | Replace user completely |
| DELETE | `/api/users/{id}` | Delete a user           |

🎫 Tickets

| Method | Endpoint            | Description               |
| ------ | ------------------- | ------------------------- |
| GET    | `/api/tickets`      | List all tickets          |
| POST   | `/api/tickets`      | Create a new ticket       |
| GET    | `/api/tickets/{id}` | Show ticket details       |
| PATCH  | `/api/tickets/{id}` | Update ticket partially   |
| PUT    | `/api/tickets/{id}` | Replace ticket completely |
| DELETE | `/api/tickets/{id}` | Delete ticket             |

## 📝 Authors & Author Tickets

GET /api/authors – List all authors

GET /api/authors/{id} – Show author details

GET /api/authors/{author}/tickets – List tickets for specific author

POST /api/authors/{author}/tickets – Create ticket for an author

PATCH/PUT /api/authors/{author}/tickets/{ticket} – Update/replace ticket

DELETE /api/authors/{author}/tickets/{ticket} – Delete ticket

## 🛡️ Authorization & Abilities

Managers 🔑 have full access:

ticket:create, ticket:update, ticket:replace, ticket:delete
user:create, user:update, user:replace, user:delete

Normal Users 👤 can only manage their own tickets:
ticket:Own:create, ticket:Own:update, ticket:Own:delete
Policies (TicketPolicy, UserPolicy) check token abilities and ownership for authorization.

## 📝 Request Validation

All API requests are validated using Laravel FormRequest classes to ensure data is correct before reaching controllers.

LoginUserRequest / ApiLoginRequest 🔑 – Validates login credentials (email and password).

BaseUserRequest & BaseTicketRequest 👤🎫 – Base classes that map JSON API fields to database columns.

Store / Update / Replace Requests 🆕✏️ – Handle validation for creating, updating, or replacing users and tickets:

StoreUserRequest / StoreTicketRequest → required fields for creation

UpdateUserRequest / UpdateTicketRequest → optional fields for partial updates

ReplaceUserRequest / ReplaceTicketRequest → required fields for full replacement

✅ Ensures consistent, clean data and automatic error responses on invalid input.

## 📦 API Resources

Laravel Resource classes are used to transform models into standardized JSON responses for the API.

TicketResource 🎫

Transforms a Ticket model into a structured JSON object.

Includes:

attributes (title, description, status, timestamps)

relationships (author info)

includes (embedded user data)

links (self-link to the ticket)

UserResource 👤

Transforms a User model into a structured JSON object.

Includes:

attributes (name, email, role, timestamps)

includes (all tickets of the user using TicketResource)

links (self-link to the author)

✅ Perfect for learning: RESTful APIs, Policies, Sanctum Tokens, and JSON:API style responses in Laravel.
