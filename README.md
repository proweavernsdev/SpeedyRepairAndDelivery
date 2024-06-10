# Speedy Repair Delivery

## Introduction
Speedy Repair Delivery is a comprehensive web and mobile application designed to streamline the delivery service process for companies, customers, and delivery riders. The application includes features for account management, booking delivery services, real-time tracking, and detailed reporting.

## Technology Stack
- **Front-End:** Ionic + Capacitor, Vue, Tailwind CSS
- **Back-End:** CodeIgniter 3
- **Third Party APIs & SDKs:** PayPal, Mapbox
- **Database:** MySQL, Firebase

## Getting Started

### Prerequisites
- Node.js and npm
- Ionic CLI
- Vue CLI
- PHP and Composer
- MySQL
- Firebase Account

### Installation
1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/speedy-repair-delivery.git
   cd speedy-repair-delivery
   ```

2. **Install front-end dependencies:**
   ```bash
   cd frontend
   npm install
   ```

3. **Install back-end dependencies:**
   ```bash
   cd ../backend
   composer install
   ```

4. **Set up the database:**
   - Create a MySQL database.
   - Import the provided SQL schema from `database/schema.sql`.

5. **Configure environment variables:**
   - Copy `.env.example` to `.env` in both `frontend` and `backend` directories.
   - Update the `.env` files with your environment-specific settings.

6. **Run the development servers:**
   - Frontend:
     ```bash
     cd frontend
     npm run serve
     ```
   - Backend:
     ```bash
     cd backend
     php -S localhost:8000
     ```

## Project Workflow

### Sprints Overview

#### Sprint 1-2: Project Setup and User Authentication
- **Tasks:**
  - Design prototype wireframe and entity relation diagram.
  - Set up project environment.

#### Sprint 3-4: Account Management and Customization
- **Tasks:**
  - Implement user authentication/registration.
  - Implement account management for companies, customers, and delivery riders.
  - Allow admin to manage user accounts.

#### Sprint 5-6: Customization, Booking Services, and Requests Pool
- **Tasks:**
  - Implement taxonomy management and configuration panels.
  - Develop delivery service request functionalities and real-time tracking.
  - Develop Requests Pool for delivery riders.

#### Sprint 7-8: Task History and Reports
- **Tasks:**
  - Enable review of ongoing/completed/canceled tasks.
  - Implement reporting system for users and admin.

#### Sprint 9-10: Review and Feedback System
- **Tasks:**
  - Develop system for users to review delivery riders and leave feedback.
  - Admin review and management functionalities.

#### Sprint 11-12: Final Touches and Testing
- **Tasks:**
  - Implement remaining features and refinements.
  - Conduct thorough testing and fix any bugs.

#### Sprint 13: Deployment and Launch
- **Tasks:**
  - Deploy the application.
  - Monitor and address any post-launch issues.

### Development Guidelines

1. **Branching Strategy:**
   - Use feature branches for new features.
   - Use hotfix branches for critical bug fixes.
   - Merge changes into `develop` for ongoing development.
   - Merge `develop` into `main` for production releases.

2. **Code Review:**
   - All code must be reviewed by at least one other developer before merging.
   - Ensure code adheres to the project's coding standards.

3. **Testing:**
   - Write unit tests for new features and bug fixes.
   - Ensure all tests pass before merging.

4. **Documentation:**
   - Update the documentation as changes are made.
   - Ensure all public methods and components are well-documented.

5. **Communication:**
   - Use the project management tool for task assignments and updates.
   - Regularly update the team on progress during stand-up meetings.

## Contributing
1. **Fork the repository**
2. **Create a new branch** (`git checkout -b feature/your-feature-name`)
3. **Commit your changes** (`git commit -am 'Add new feature'`)
4. **Push to the branch** (`git push origin feature/your-feature-name`)
5. **Create a new Pull Request**

## License
This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

## Contact
For any questions or suggestions, please contact the project maintainer at [maintainer@example.com].