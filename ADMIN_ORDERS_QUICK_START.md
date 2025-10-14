# Admin Orders - Quick Start Guide

## Access the Orders Management

1. **Login to Admin Portal:** `/admin/login`
2. **Click "Orders"** in the sidebar menu (under the Sales section)
3. **You're now in the Orders Management Interface!**

## What You'll See

### 📊 Dashboard Statistics (Top of Page)
Four summary cards showing:
- **Total Revenue** - All-time revenue from both customer orders and POS sales
- **Total Orders** - Combined count of online and walk-in orders
- **Customer Orders** - Online shop orders with pending/processing counts
- **POS Sales** - Walk-in transactions processed through POS

### 🔍 Filter Panel
Search and filter orders by:
- **Search Bar** - Find by order number, customer name, phone, receipt number
- **Status Filter** - Filter by pending, processing, completed, cancelled, or walk-in
- **Date Range** - Select from/to dates to view orders in specific timeframe
- **Clear Button** - Reset all filters

### 📋 Two Order Tables

#### 1️⃣ Customer Orders (Purple Header)
Shows orders placed through the online shop:
- Order number
- Customer details (name, email, phone)
- Number of items
- Total amount
- Status badge (color-coded)
- Order date and time
- Actions: **View** | **Print**

#### 2️⃣ POS Sales (Orange Header)
Shows walk-in sales processed through POS:
- Receipt number
- Customer info (if provided)
- Cashier name
- Number of items
- Total amount
- Payment method badge
- Sale date and time
- Actions: **View** | **Print**

## Key Features

### 🛍️ View Customer Order Details
Click "View" on any customer order to see:
- **Complete order information** with status
- **List of all products** ordered with prices and quantities
- **Customer details** and contact info
- **Delivery address** and order notes
- **Order timeline** (created, completed, cancelled dates)
- **Update Status Button** - Change order status
- **Print Order Button** - Generate professional invoice

### 💰 View POS Sale Details
Click "View" on any POS sale to see:
- **Receipt details** with sale number
- **Products sold** with quantities and prices
- **Customer information** (if provided)
- **Cashier details**
- **Payment information** (method and reference)
- **Sale statistics**
- **Print Receipt Button** - Generate thermal-style receipt

### ✏️ Update Order Status
For customer orders (not POS sales):
1. Open the order details
2. Use the "Update Status" dropdown in the sidebar
3. Select new status:
   - **Pending** → Order received, waiting to be processed
   - **Processing** → Order being prepared
   - **Completed** → Order fulfilled and delivered
   - **Cancelled** → Order cancelled (stock automatically restored)
4. Click "Update Status"
5. System automatically handles stock adjustments

### 🖨️ Print Functionality

#### Print Customer Order Invoice
- Professional business invoice format
- Company header and order details
- Complete items list with prices and tax
- Customer and delivery information
- Suitable for records and customer copy
- Click "Print Order" button and use browser print

#### Print POS Receipt
- Thermal printer style (80mm width)
- Compact receipt format
- Receipt number and sale details
- Items with quantities and totals
- Payment method and reference
- Thank you message
- Click "Print Receipt" and use thermal printer or save as PDF

## How Orders Work

### Customer Orders Flow:
1. Customer places order through online shop → Status: **Pending**
2. Admin reviews and confirms → Status: **Processing**
3. Order prepared and delivered → Status: **Completed**
4. (If needed) Order cancelled → Status: **Cancelled** (stock restored)

### POS Sales Flow:
1. Cashier processes sale at POS → Status: **Completed** (immediate)
2. Receipt generated automatically
3. Stock deducted in real-time
4. Sale recorded with cashier and payment info

## Status Colors

| Status | Color | Meaning |
|--------|-------|---------|
| **Pending** | 🟡 Yellow | Awaiting processing |
| **Processing** | 🔵 Blue | Being prepared |
| **Completed** | 🟢 Green | Finished/Delivered |
| **Cancelled** | 🔴 Red | Cancelled by admin/customer |

## Common Tasks

### Find a Specific Order
1. Use the **Search Bar**
2. Enter order number, customer name, or phone
3. Click "Filter"

### View Today's Orders
1. Set **From Date** to today's date
2. Set **To Date** to today's date
3. Click "Filter"

### View Only Pending Orders
1. Select **"Pending"** from Status dropdown
2. Click "Filter"

### View All Walk-in Sales
1. Select **"Walk-in (POS)"** from Status dropdown
2. Click "Filter"

### Generate Monthly Report
1. Set **From Date** to first day of month
2. Set **To Date** to last day of month
3. Click "Filter"
4. Use browser print to save as PDF

## Tips & Tricks

✅ **Filter by multiple criteria** - Combine search, status, and date filters
✅ **Print in bulk** - Open multiple orders in new tabs, then print all
✅ **Track cashier performance** - Filter POS sales to see individual cashier activity
✅ **Monitor pending orders** - Check pending status regularly to process orders promptly
✅ **Use date ranges** - Analyze sales patterns by filtering specific periods
✅ **Customer follow-up** - Use customer contact info from order details

## Quick Stats Interpretation

### Total Revenue
- Shows combined revenue from ALL sources
- Includes today's revenue breakdown
- Useful for daily/monthly performance tracking

### Total Orders
- Combined count: Online orders + Walk-in sales
- Gives complete picture of business volume

### Customer Orders Stats
- Pending count: Orders waiting for action
- Processing count: Orders currently being handled
- Action needed if pending count is high

### POS Sales Stats
- Walk-in customer transactions
- Immediate completed sales
- Reflects in-store traffic

## Troubleshooting

**Issue:** Can't update order status
- **Solution:** Cancelled orders cannot be changed. Create new order if needed.

**Issue:** Print button not working
- **Solution:** Check browser pop-up settings. Allow pop-ups for the site.

**Issue:** No orders showing
- **Solution:** Clear all filters first. Check if there are any orders in the system.

**Issue:** Wrong date range
- **Solution:** Ensure "From Date" is before "To Date". Clear filters and try again.

## Need Help?

- 📧 Contact system administrator
- 📚 Refer to ADMIN_ORDERS_IMPLEMENTATION.md for technical details
- 🔧 Check Laravel logs if errors occur: `storage/logs/laravel.log`

---

**You're all set!** The Orders management system is fully functional and ready to help you efficiently manage all orders from both your online shop and POS system. 🎉
