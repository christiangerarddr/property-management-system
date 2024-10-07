## Property Management System

Our Property Management System (PMS) is a user-friendly web application designed to help property owners and real estate brokers effortlessly manage their properties. It streamlines everyday tasks like tenant management, lease tracking, maintenance requests, automatic rent billing, and financial reporting. With convenient features such as online rent collection and intuitive communication tools, our app makes organization a breeze and significantly enhances the overall experience for tenants.

To enhance engagement, our app includes gamification features, such as reward systems for timely rent payments, completed maintenance tasks, and participation in community activities. Plus, we offer a Good Samaritan bulletin board where tenants can recognize each other’s helpful actions. This not only motivates tenants but also builds a sense of community, making property management smoother and more enjoyable for everyone involved!

- **Tenant Management**: Easily track tenant information, applications, and communications.
- **Lease Tracking**: Stay on top of lease agreements, renewals, and expirations.
- **Maintenance Requests**: Allow tenants to submit maintenance issues online, streamlining communication and response times.
- **Automatic Rent Billing**: Set up automated rent collection to ensure timely payments without the hassle.
- **Online Rent Collection**: Offer tenants the convenience of paying rent online, improving cash flow and reducing late payments.
- **Financial Reporting**: Access comprehensive reports to monitor income, expenses, and overall property performance.
- **Communication Tools**: Foster seamless communication with tenants through messages and notifications.
- **Gamification Elements**: Encourage tenant engagement with rewards for timely payments or participation in community events, creating a sense of community and motivation.

## Installation instructions

Follow these steps to install and set up the Property Management System (PMS):

### Prerequisites

Before you begin, ensure you have the following installed on your system:

- **NODE** (version 18 or higher)
- **NPM** (version 10 or higher)
- **PHP** (version 8.3 or higher)
- **COMPOSER** (version 2.7 or higher)

You’re free to choose which database of you want!

### Run on your local

```bash
git clone git@github.com:christiangerarddr/property-management-system.git
cd property-management-system

composer install
php artisan migrate --seed

npm install
npm run build
```
