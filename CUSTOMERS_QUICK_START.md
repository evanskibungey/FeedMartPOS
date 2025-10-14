# Customer Management - Quick Start Guide

## Access Customer Management

1. Log into the Admin Portal at `/admin/login`
2. Click on **"Customers"** in the sidebar under the "Sales" section
3. You'll see the customer dashboard with statistics and a list of all customers

## Quick Actions

### Add a New Customer
1. Click the **"Add New Customer"** button (top right)
2. Fill in the customer details:
   - Full Name (required)
   - Email or Phone (at least one required)
   - Password (required)
3. Click **"Create Customer"**

### View Customer Details
1. In the customer list, click the **eye icon** (👁️) next to any customer
2. You'll see:
   - Customer profile information
   - Order statistics
   - Complete order history

### Edit Customer Information
1. Click the **edit icon** (✏️) next to any customer, OR
2. Click **"Edit Customer"** button on the customer details page
3. Update the information
4. Click **"Update Customer"**

### Change Customer Password
1. Go to the customer's edit page
2. Scroll down to the **"Change Password"** section
3. Enter new password and confirmation
4. Click **"Update Password"**

### Activate/Deactivate Customer
1. In the customer list, click the **status toggle icon** (🔄)
2. Confirm the action
3. Customer's status will be updated immediately
   - **Active**: Customer can log in
   - **Inactive**: Customer cannot log in

### Delete Customer
1. In the customer list, click the **delete icon** (🗑️) next to any customer
2. Confirm the deletion
3. **Note**: Customers with existing orders cannot be deleted

## Understanding the Dashboard

### Statistics Cards
- **Total Customers**: Count of all registered customers
- **Active**: Customers who can currently log in
- **With Orders**: Customers who have placed at least one order
- **New This Month**: Customers registered in the current month

### Customer List Columns
- **Customer**: Avatar, name, and customer ID
- **Contact**: Email and phone number
- **Orders**: Number of orders placed (badge)
- **Status**: Active/Inactive indicator
- **Joined**: Registration date
- **Actions**: Quick action buttons

## Routes Reference

```
/admin/customers                           → Customer list
/admin/customers/create                    → Add new customer form
/admin/customers/{id}                      → View customer details
/admin/customers/{id}/edit                 → Edit customer form
```

## Validation Rules

### Creating a Customer:
- ✅ Name is required
- ✅ Either email OR phone must be provided
- ✅ Email must be unique and valid format
- ✅ Phone must be unique
- ✅ Password must meet security requirements
- ✅ Password confirmation must match

### Editing a Customer:
- ✅ Same as above, except password is optional
- ✅ Status (Active/Inactive) is required

## Tips & Best Practices

1. **Contact Information**: Always ensure at least one contact method (email or phone) is provided
2. **Status Management**: Use Inactive status instead of deleting customers when possible
3. **Order Protection**: The system automatically prevents deletion of customers with orders
4. **Password Security**: Use strong passwords when creating customer accounts
5. **Bulk Import**: For adding many customers, consider using the database seeder or import tool

## Troubleshooting

### Cannot delete a customer?
- Check if the customer has any orders
- Customers with orders are protected from deletion
- Set them to "Inactive" instead if needed

### Email/Phone already exists?
- Each email and phone must be unique across all users
- Check if another customer or staff member is using it

### Customer cannot log in?
- Verify their account status is "Active"
- Check if email/phone is correct
- Try resetting their password

## Integration with Other Modules

### Orders Module
- Customers can place orders through the customer portal
- View all customer orders in the customer details page
- Order history shows order status, date, items, and total

### POS Module  
- Walk-in customers can be linked to customer accounts
- POS operators can search for existing customers during checkout

### Reports Module (Coming Soon)
- Customer analytics and insights
- Customer lifetime value
- Purchase patterns and trends

## For Developers

### Controller Location
`app/Http/Controllers/Admin/CustomerController.php`

### Views Location
`resources/views/admin/customers/`
- `index.blade.php` - Customer list
- `create.blade.php` - Create form
- `edit.blade.php` - Edit form  
- `show.blade.php` - Customer details

### Routes Namespace
`admin.customers.*`

### Database Table
`users` table where `role = 'customer'`

### Relationships
- `User::orders()` - HasMany relationship to Order model

---

## Need Help?

If you encounter any issues or need assistance:
1. Check the validation error messages
2. Review this quick start guide
3. Consult the full implementation documentation: `CUSTOMERS_IMPLEMENTATION.md`
4. Check application logs for detailed error information

---

**Last Updated**: October 2025
**Version**: 1.0
**Module**: Customer Management
