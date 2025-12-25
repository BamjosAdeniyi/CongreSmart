# Church Management System - User Flow Documentation

## Table of Contents
1. [Introduction](#introduction)
2. [Common User Flows](#common-user-flows)
3. [Role-Specific User Flows](#role-specific-user-flows)
4. [Detailed Screen-by-Screen Flows](#detailed-screen-by-screen-flows)
5. [Mobile User Experience](#mobile-user-experience)
6. [Error Handling and Edge Cases](#error-handling-and-edge-cases)
7. [User Interface Guidelines](#user-interface-guidelines)

---

## Introduction

This documentation provides comprehensive user flows for the Seventh-day Adventist Church Management System from the user's perspective. It details every interaction, screen, and decision point users encounter while using the system.

### System Access Points
1. **Landing Page** - First entry point
2. **Login Page** - Authentication
3. **Dashboard** - Role-specific home screen
4. **Main Navigation** - Sidebar menu
5. **Module Pages** - Functional areas

### User Credentials (Test Accounts)
```
Pastor: pastor@church.com / pastor123
Clerk: clerk@church.com / clerk123
Welfare: welfare@church.com / welfare123
Superintendent: superintendent@church.com / super123
Coordinator: coordinator1@church.com / coord123
Financial: financial@church.com / finance123
ICT: ict@church.com / ict123
```

---

## Common User Flows

### FLOW 1: First-Time User Access

**Starting Point:** User opens the application

**Steps:**

1. **Landing Page (Welcome Screen)**
   - **What User Sees:**
     - Header with Pioneer SDA Church logo and "Sign In" button
     - Hero section with large SDA logo and church name
     - "Pioneer Seventh-Day Adventist Church" heading
     - "Comprehensive Church Management System" subheading
     - Three feature cards:
       * Member Management (Users icon)
       * Sabbath School (BookOpen icon)
       * Financial Tracking (Heart icon)
     - "Access Church System" button (yellow, prominent)
     - Footer with copyright and Bible verse
   
   - **User Actions:**
     - Click "Sign In" button (top right) → Goes to Login Page
     - OR Click "Access Church System" button (center) → Goes to Login Page
   
   - **Mobile View:**
     - Stacked layout
     - Larger touch targets
     - Simplified hero section

2. **Login Page**
   - **What User Sees:**
     - Church logo and name at top
     - Card with "Welcome Back" heading
     - Email input field (placeholder: "Enter your email")
     - Password input field (placeholder: "Enter your password")
     - "Sign In" button
     - Optional: "Forgot Password?" link
   
   - **User Actions:**
     - Enter email address
     - Enter password
     - Click "Sign In" button
   
   - **Validation:**
     - Email format validation
     - Password minimum length
     - Error message if credentials invalid: "Invalid email or password"
   
   - **Success:**
     - User is logged in
     - Redirected to role-specific dashboard

3. **Dashboard (Role-Specific)**
   - User sees their personalized dashboard
   - Continue to role-specific flows below

---

### FLOW 2: Daily Login (Returning User)

**Starting Point:** User opens the application (has logged in before)

**Steps:**

1. **Automatic Landing Page Check**
   - System checks if user has stored credentials (localStorage)
   
   **If credentials exist:**
   - Skip landing page
   - Go directly to Login page
   - Email may be pre-filled
   
   **If no stored credentials:**
   - Show Landing Page (see Flow 1)

2. **Login**
   - Enter credentials
   - Click "Sign In"
   - Go directly to dashboard

3. **Dashboard**
   - User sees their role-specific dashboard
   - Continue working

---

### FLOW 3: Navigation Between Pages

**Starting Point:** User is logged in and on any page

**Primary Navigation Method:** Sidebar Menu

**Sidebar Structure:**
```
Dashboard (Home icon)
├─ Members (Users icon)
├─ Sabbath School (BookOpen icon)
├─ Finance (DollarSign icon)
├─ Reports (FileText icon)
├─ Notifications (Bell icon) [Badge if unread]
├─ Settings (Settings icon)
└─ Administration (Shield icon) [ICT only]
```

**Steps:**

1. **Desktop Navigation:**
   - Sidebar always visible on left side
   - Current page highlighted with blue background
   - User clicks any menu item
   - Page content changes in main area (right side)
   - Sidebar remains visible
   - Mobile menu state is closed

2. **Mobile Navigation:**
   - Hamburger icon (Menu) in top-left of navbar
   - User taps hamburger icon
   - Sidebar slides in from left
   - Overlay appears behind sidebar
   - User taps menu item → Sidebar closes, page changes
   - OR User taps overlay → Sidebar closes, stays on same page

3. **Breadcrumb Navigation (Some Pages):**
   - Shows current location
   - Example: "Dashboard > Members > Add Member"
   - User can click breadcrumb links to go back
   - Useful for deep navigation

4. **Back Buttons:**
   - Sub-pages have "Back" button with arrow icon
   - Located top-left of page content
   - Returns to parent page
   - Example: "Add Member" has back to "Member List"

---

### FLOW 4: Notifications

**Starting Point:** User is logged in

**Notification Bell Flow:**

1. **Notification Indicator**
   - Bell icon in top-right navbar
   - Red badge shows unread count (e.g., "3")
   - User clicks bell icon

2. **Notification Center Page**
   - **What User Sees:**
     - Page title: "Notifications"
     - Filter buttons:
       * All
       * Birthdays
       * Absences
       * System
     - List of notifications (cards)
     - Each notification shows:
       * Priority indicator (colored dot: red=high, yellow=medium, blue=low)
       * Type badge
       * Title
       * Message
       * Date/time
       * Read/unread status (bold if unread)
   
   - **User Actions:**
     - Click filter button → Shows only that type
     - Click notification → Marks as read, shows details
     - Click "Mark All as Read" → All marked as read
     - Badge updates in real-time

3. **Auto-Generated Notifications:**
   - **Birthdays:** Appear 7 days before member birthday
   - **Absences:** After 3 consecutive weeks absent
   - **Transfers:** When transfer created/approved
   - **System:** Important updates

---

### FLOW 5: Logout

**Starting Point:** User is logged in on any page

**Steps:**

1. **User Profile Menu**
   - Top-right corner of navbar
   - Shows user avatar (or initials)
   - Shows user name
   - Dropdown arrow icon

2. **Open Dropdown**
   - User clicks on profile area
   - Dropdown menu appears
   - Options shown:
     * View Profile
     * Settings
     * Logout (red color)

3. **Click Logout**
   - User clicks "Logout"
   - System clears stored credentials
   - System clears session data
   - User redirected to Landing Page
   - Logged out state

4. **Re-login Required**
   - To access system again, must login
   - Credentials not saved

---

## Role-Specific User Flows

### PASTOR User Flow

**Dashboard Overview:**
- Metrics: Total Members, Weekly Attendance, Monthly Contributions, Baptisms This Year
- Charts: Attendance Trend (line chart)
- Widgets: Recent Baptisms, Upcoming Events
- Quick Actions: View Reports, View All Members

#### Pastor Flow 1: View Member Statistics

1. **From Dashboard**
   - See "Total Members" card (e.g., "248")
   - Click card → Navigate to Members page

2. **Members Page**
   - View list of all members
   - **Cannot add/edit/delete** (view-only access)
   - Search and filter members
   - Click member name → View member details

3. **Member Detail Page**
   - See comprehensive member information
   - Personal info, membership details, baptism status
   - Contribution history (amounts visible)
   - Attendance history
   - **No edit buttons** (read-only)

#### Pastor Flow 2: View Financial Reports

1. **From Dashboard**
   - Click "Monthly Contributions" card
   - OR Click "Reports" in sidebar

2. **Reports Page**
   - See report types:
     * Membership Reports
     * Attendance Reports
     * Financial Reports
   - Click "Financial Reports"

3. **Financial Reports**
   - Select date range (this month, last month, custom)
   - Select category filter (all, tithe, offerings)
   - Click "Generate Report"

4. **View Results**
   - See summary statistics:
     * Total contributions
     * Number of contributors
     * Average per person
   - Charts:
     * Pie chart (by category)
     * Bar chart (top contributors)
     * Line chart (trend)
   - Detailed table with all contributions

5. **Export Report**
   - Click "Export" button
   - Choose format: PDF or Excel
   - File downloads
   - Activity logged

#### Pastor Flow 3: Review Attendance

1. **Navigate to Reports**
   - Click "Reports" in sidebar
   - Select "Attendance Reports"

2. **Configure Report**
   - Select date range
   - Select class (all or specific)
   - Click "Generate"

3. **View Attendance Data**
   - Overall attendance percentage
   - Class-by-class breakdown
   - Member attendance rates
   - Identify absent members

---

### CHURCH CLERK User Flow

**Dashboard Overview:**
- Metrics: Total Members, New Members This Month, Birthdays This Month, Absent Members (3+ weeks)
- Widgets: Recently Added Members, Upcoming Birthdays (next 7 days)
- Quick Actions: Add Member, Manage Transfers

#### Clerk Flow 1: Add New Member

1. **From Dashboard**
   - Click "Add Member" button
   - OR Navigate to Members → Click "Add Member"

2. **Add Member Form**
   - **Personal Information Section:**
     - First Name * (required)
     - Last Name *
     - Family Name * (e.g., "Smith Family")
     - Gender * (dropdown: Male/Female)
     - Date of Birth * (date picker)
     - Phone *
     - Email
     - Address * (textarea)
   
   - **Membership Details Section:**
     - Membership Type * (dropdown: Community/Student)
     - Membership Category * (dropdown: Adult/Youth/Child/University Student)
     - Role in Church * (e.g., "Elder", "Deaconess", "Member")
     - Baptism Status * (dropdown: Baptized/Not Baptized/Pending)
     - Date of Baptism (if baptized - date picker)
     - Membership Date * (date joined church)
   
   - **Optional:**
     - Photo upload
     - Sabbath School Class assignment

3. **Validation**
   - All required fields must be filled
   - Email format checked
   - Phone format checked
   - If baptized, baptism date required
   - Baptism date must be after birth date

4. **Save Member**
   - Click "Save Member" button
   - System validates all fields
   - System creates member record
   - Success notification: "Member added successfully!"
   - Activity logged: CREATE_MEMBER
   - Redirected to Member List

5. **View New Member**
   - New member appears in list
   - Status: Active
   - Can search for member by name

#### Clerk Flow 2: Edit Existing Member

1. **Find Member**
   - Navigate to Members page
   - Search by name or email
   - OR filter by status
   - Click "View" or member name

2. **Member Detail Page**
   - See all member information
   - Click "Edit Member" button

3. **Edit Form**
   - Same form as Add Member
   - Fields pre-filled with current data
   - Make changes
   - Click "Save Changes"

4. **Save**
   - Validation runs
   - Updates saved
   - Success notification
   - Activity logged: UPDATE_MEMBER
   - Return to detail view

#### Clerk Flow 3: Transfer Member TO Another Church

**Scenario:** Member is moving to another city/church

1. **Navigate to Transfer Management**
   - Option 1: From Dashboard → Click "Manage Transfers" button
   - Option 2: Members → Member Detail → Click "Transfer Member"
   - Option 3: Sidebar → Members → Transfer Management link

2. **Transfer Management Page**
   - **What User Sees:**
     - Page title: "Transfer Management"
     - Description: "Track member transfers between churches"
     - "Add Transfer" button
     - Tabs:
       * All Transfers
       * Outgoing (To other churches)
       * Incoming (From other churches)
     - List of existing transfers with:
       * Member name
       * Direction (To/From)
       * Church name
       * Date
       * Status badge
       * Action buttons

3. **Click "Add Transfer"**
   - Form dialog opens
   
4. **Fill Transfer Form**
   - **Select Member:**
     - Dropdown or search field
     - Shows all active members
     - Select member who is transferring
   
   - **Transfer Direction:**
     - Radio buttons: "To Another Church" / "From Another Church"
     - Select "To Another Church"
   
   - **Destination Church:**
     - Text input: "Name of destination church"
     - Optional: Church address
   
   - **Transfer Date:**
     - Date picker
     - Usually today or recent past
   
   - **Status:**
     - Dropdown: "Not Transferred" (initial) or "Transferred"
     - Start with "Not Transferred" (pending)
   
   - **Notes:**
     - Textarea (optional)
     - Can include reason, contact info, etc.

5. **Save Transfer**
   - Click "Save Transfer" button
   - System validates:
     * Member selected
     * Church name provided
     * Date not in future
   - Transfer record created
   - Success notification
   - Activity logged: CREATE_TRANSFER

6. **Update Transfer Status (Later)**
   - When transfer confirmed
   - Find transfer in list
   - Click "Edit" button
   - Change status to "Transferred"
   - Save
   - **System automatically:**
     * Updates member status to "transferred"
     * Member moves to transferred list
     * Notification generated

7. **View Transfer in Member Detail**
   - Go to member's detail page
   - See "Transfer Information" section
   - Shows:
     * Status badge: "Transferred"
     * Direction: "To [Church Name]"
     * Transfer date
     * Notes

#### Clerk Flow 4: Register Member FROM Another Church

**Scenario:** New member transferring in from another SDA church

1. **Add Member First**
   - Go to Members → Add Member
   - Fill in all member information
   - Mark as Active
   - Save member

2. **Add Transfer Record**
   - Navigate to Transfer Management
   - Click "Add Transfer"

3. **Fill Transfer Form**
   - **Select Member:** Choose the newly added member
   - **Transfer Direction:** Select "From Another Church"
   - **Source Church:** Enter name of previous church
   - **Transfer Date:** Date they transferred in
   - **Status:** Select "Transferred" (already completed)
   - **Notes:** Any relevant information

4. **Save**
   - Transfer record created
   - Member detail shows they came from another church
   - Member is active in current church

#### Clerk Flow 5: Track Birthdays

1. **From Dashboard**
   - See "Birthdays This Month" widget
   - Shows count and list of upcoming birthdays

2. **View Details**
   - Click on birthday widget
   - OR go to Reports → Membership Reports → Birthday Report

3. **Birthday Report**
   - Filter by month or date range
   - See list of members with birthdays
   - Information shown:
     * Name
     * Date of birth
     * Age (turning)
     * Contact info

4. **Export for Communication**
   - Click "Export" → Choose format
   - Use for birthday cards/messages

---

### WELFARE DIRECTOR User Flow

**Dashboard:** Same as Clerk (limited permissions)

**Primary Use Case:** Monitor member wellbeing

#### Welfare Flow 1: Check Absent Members

1. **From Dashboard**
   - See "Absent Members" widget
   - Shows count of members absent 3+ weeks

2. **Click Widget**
   - See detailed list
   - Member name, last attendance date, weeks absent

3. **View Member Details**
   - Click member name
   - See contact information
   - See attendance history

4. **Take Action**
   - **Cannot edit records** (read-only)
   - Use contact info to:
     * Call member
     * Visit member
     * Send message
   - Report findings to Pastor/Clerk

#### Welfare Flow 2: Access Contact Directory

1. **Navigate to Members**
   - View all members

2. **Search/Filter**
   - Search by family name
   - Filter by category (adult, youth, child)

3. **View Contact Info**
   - Click member → See phone, email, address
   - **Cannot edit** (view-only)

4. **Export Directory**
   - Navigate to Reports
   - Select "Membership Reports"
   - Generate member directory
   - Export to PDF
   - Use for visits/communication

---

### SABBATH SCHOOL SUPERINTENDENT User Flow

**Dashboard Overview:**
- Metrics: Total Classes, Total Students, Average Attendance %, This Week's Attendance
- Widgets: Class List (with coordinators and member counts), Attendance Trend Chart
- Quick Actions: Manage Classes, View Attendance

#### Superintendent Flow 1: Create New Sabbath School Class

1. **From Dashboard**
   - Click "Manage Classes"
   - OR Navigate to Sabbath School → Click "Class Management"

2. **Sabbath School Page (Hub)**
   - **What User Sees:**
     - Four large action cards:
       * Class Management (blue hover)
       * Assign Members (green hover)
       * Mark Attendance (purple hover)
       * Attendance Reports (yellow hover)

3. **Click "Class Management"**
   - See existing classes table:
     * Class Name
     * Coordinator
     * Member Count
     * Age Range
     * Status (Active/Inactive)
     * Action buttons (Edit, Delete)

4. **Click "Add Class" Button**
   - Form dialog opens

5. **Fill Class Form**
   - **Class Name:** (e.g., "Adult Class", "Youth Class")
   - **Select Coordinator:**
     - Dropdown of users with 'coordinator' role
     - Must select one
   - **Age Range:** (optional, e.g., "18-35")
   - **Description:** (optional)

6. **Save Class**
   - Click "Save"
   - Validation:
     * Name required and unique
     * Coordinator required
   - Class created
   - Success notification
   - Activity logged: CREATE_CLASS
   - Class appears in list

#### Superintendent Flow 2: Assign Members to Classes

1. **From Sabbath School Hub**
   - Click "Assign Members" card

2. **Assign Members Page**
   - **Left Side:** List of all members
   - **Right Side:** Class selection
   
   **OR**
   
   - **Top:** Class selector
   - **Below:** Members in that class + Available members

3. **Assignment Process**
   - Select a class from dropdown
   - See current members in that class
   - See list of unassigned members
   - Search/filter members
   - Select members (checkboxes)
   - Click "Assign to [Class Name]"

4. **Save Assignments**
   - Click "Save Assignments"
   - Members' sabbathSchoolClassId updated
   - Success notification
   - Activity logged: ASSIGN_MEMBERS
   - Member count in class updates

#### Superintendent Flow 3: View Attendance Reports

1. **From Sabbath School Hub**
   - Click "Attendance Reports" card

2. **Attendance Reports Page**
   - **Filters:**
     - Date range selector (This week, This month, Custom)
     - Class filter (All classes or specific)
   
3. **Generate Report**
   - Click "Generate Report"
   - System queries attendance data

4. **View Results**
   - **Summary Statistics:**
     * Overall attendance rate
     * Total present
     * Total absent
   
   - **Class Breakdown Table:**
     * Class name
     * Total members
     * Present today/period
     * Attendance percentage
   
   - **Charts:**
     * Line chart: Attendance trend over time
     * Bar chart: Attendance by class
   
   - **Member Details:**
     * Individual attendance rates
     * Consecutive absences

5. **Export Report**
   - Click "Export"
   - Choose PDF or Excel
   - File downloads

#### Superintendent Flow 4: Monitor Class Coordinator Performance

1. **From Dashboard**
   - View "Class List" widget
   - See each class with:
     * Coordinator name
     * Member count
     * Recent attendance

2. **Identify Issues**
   - Low attendance in specific class
   - No recent attendance marked

3. **View Class Details**
   - Click class name
   - See full attendance history
   - See coordinator information

4. **Take Action**
   - Contact coordinator if issues
   - Reassign coordinator if needed (Edit Class)

---

### CLASS COORDINATOR User Flow

**Dashboard Overview:**
- Metrics: Assigned Class, Class Members, Attendance Rate, Recent Attendance
- Widgets: Class Member List, Weekly Attendance Chart, Top Attendees
- Quick Actions: Mark Attendance, View Class Report

**Important:** Coordinator sees only THEIR assigned class

#### Coordinator Flow 1: Mark Attendance (Primary Task)

1. **From Dashboard**
   - Click "Mark Attendance" button
   - OR Navigate to Sabbath School → "Mark Attendance"

2. **Attendance Marking Page**
   - **Auto-loaded:** Coordinator's assigned class
   - **Date Selector:** 
     - Defaults to most recent Saturday
     - Can select previous Saturdays
     - **Cannot select future dates**
     - **Only Saturdays shown** (validation)

3. **View Member List**
   - Table shows all members in their class:
     * Member name
     * Last attendance
     * Attendance streak
     * Present checkbox
     * Notes field (optional)

4. **Mark Attendance**
   - **Quick Actions:**
     * "Mark All Present" button
     * "Mark All Absent" button
   
   - **Individual Marking:**
     * Check box next to member name = Present
     * Uncheck = Absent
     * Add notes if needed (e.g., "Sick", "Out of town")

5. **Save Attendance**
   - Click "Save Attendance"
   - System validates:
     * Date is Saturday
     * Date not in future
   - Creates AttendanceRecord for each member
   - Success notification: "Attendance saved for [Date]"
   - Activity logged: MARK_ATTENDANCE

6. **Review Previous Attendance**
   - Change date selector to previous Saturday
   - See previously marked attendance
   - Can edit if needed
   - Save changes

#### Coordinator Flow 2: View Class Report

1. **From Dashboard**
   - Click "View Class Report"
   - OR Navigate to Sabbath School → "Attendance Reports"

2. **Class Report**
   - **Filtered to their class only**
   - Select date range
   - Click "Generate"

3. **View Results**
   - Overall class attendance rate
   - Attendance trend chart
   - Member-by-member breakdown
   - Identify absent members

4. **Take Action**
   - Follow up with absent members
   - Report concerns to Superintendent

---

### FINANCIAL SECRETARY User Flow

**Dashboard Overview:**
- Metrics: Total Contributions (This Month), Total Contributors, Tithe Collected, Offerings Collected
- Widgets: Top Contributors, Recent Contributions, Monthly Trend Chart
- Quick Actions: Record Contributions, View Reports

#### Financial Flow 1: Record Weekly Contributions (Bulk Entry)

**Scenario:** It's Sabbath, contributions collected, need to record all amounts

1. **From Dashboard**
   - Click "Record Contributions"
   - OR Navigate to Finance → "Record Contributions"

2. **Record Contributions Page**
   - **Header Controls:**
     - Date selector (defaults to today)
     - Usually select Sabbath date
   
3. **Contribution Grid**
   - **What User Sees:**
     - Large table/grid
     - **Rows:** All active members (names in first column)
     - **Columns:** All active financial categories
       * Tithe
       * Sabbath School Offering
       * Church Building Fund
       * Mission Offering
       * Local Church Budget
       * Disaster Relief
       * Thanksgiving Offering
       * (Any custom categories)
   
   - **Grid Cells:** Input fields for amounts

4. **Enter Contributions**
   - **Process:**
     - Go row by row (member by member)
     - For each member, enter amounts in relevant categories
     - Leave blank if no contribution in that category
     - Only enter for members who contributed
   
   - **Real-time Calculations:**
     - Last column shows row total (per member)
     - Bottom row shows column total (per category)
     - Grand total in bottom-right corner
   
   - **Currency:**
     - All amounts in Naira (₦)
     - Display shows ₦ symbol
     - Enter numbers only (e.g., "5000" → displays "₦5,000.00")

5. **Review Totals**
   - Check row totals match member envelopes
   - Check column totals match category counts
   - Check grand total matches total collected

6. **Save All Contributions**
   - Click "Save All" button
   - System validates:
     * All amounts are positive numbers
     * Date is valid
   - System creates Contribution record for each non-zero entry
   - Success notification: "Successfully recorded [count] contributions"
   - Activity logged: RECORD_CONTRIBUTION
   - Grid clears for next entry

#### Financial Flow 2: Record Individual Contribution

**Scenario:** Late contribution or special donation

1. **Navigate to Member**
   - Go to Members
   - Search for member
   - Click member name

2. **Member Detail Page**
   - Scroll to "Contribution History" section
   - Click "Add Contribution" button

3. **Contribution Form**
   - **Category:** Dropdown (select one category)
   - **Amount:** Input field (₦)
   - **Date:** Date picker
   - **Payment Method:** Dropdown
     * Cash
     * Bank Transfer
     * Check
     * Mobile Money
   - **Reference Number:** (if Bank Transfer or Check)
   - **Notes:** Textarea (optional)

4. **Save**
   - Click "Save"
   - Validation runs
   - Contribution recorded
   - Appears in member's history
   - Appears in reports

#### Financial Flow 3: Manage Financial Categories

1. **Navigate to Finance → "Manage Categories"**

2. **Financial Categories Page**
   - See list of all categories:
     * Name
     * Description
     * Type (Tithe/Offering/Donation/Other)
     * Fund Status (Active/Inactive)
     * Action buttons

3. **Add New Category**
   - Click "Add Category"
   - Fill form:
     * Name (e.g., "Women's Ministries Fund")
     * Description
     * Category Type
     * Active (checkbox, default checked)
   - Save
   - Category created
   - Appears in contribution grid

4. **Deactivate Category**
   - Find category in list
   - Click "Edit"
   - Uncheck "Active"
   - Save
   - Category no longer appears in contribution recording
   - **Existing contributions preserved**

#### Financial Flow 4: Generate Financial Reports

1. **Navigate to Finance → "Financial Reports"**

2. **Report Configuration**
   - **Date Range:**
     - Quick select: This Week, This Month, This Quarter, This Year
     - OR Custom: Start Date - End Date
   
   - **Category Filter:**
     - All Categories
     - Tithe Only
     - Offerings Only
     - Specific Category
   
   - **Group By:**
     - Category (see totals per fund)
     - Member (see totals per person)
     - Date (see daily/weekly totals)

3. **Generate Report**
   - Click "Generate Report"
   - System queries contribution data

4. **View Results**
   - **Summary Cards:**
     * Total Contributions
     * Number of Contributors
     * Average Contribution
     * Largest Contribution
   
   - **Charts:**
     * Pie Chart: Breakdown by category
     * Bar Chart: Top 10 contributors
     * Line Chart: Trend over time
   
   - **Detailed Table:**
     * Date, Member, Category, Amount
     * Sortable columns
     * Searchable
     * Pagination

5. **Export Report**
   - Click "Export" dropdown
   - Choose:
     * PDF (formatted, with charts)
     * Excel (data table, for further analysis)
   - File downloads
   - Activity logged: EXPORT_REPORT

#### Financial Flow 5: View Member Contribution History

1. **Navigate to Members**
   - Search for member
   - Click member name

2. **Member Detail Page**
   - Scroll to "Contribution History" section
   - See table:
     * Date
     * Category
     * Amount (₦)
     * Recorded By
   - Sorted by date (newest first)

3. **View Totals**
   - See summary below table:
     * Total contributed (all time)
     * Total by category
     * Average monthly contribution

4. **Filter History**
   - Date range filter
   - Category filter
   - Apply filters → Updated view

---

### ICT ADMINISTRATOR User Flow

**Dashboard Overview:**
- Metrics: Total Users, Active Users, System Uptime, Storage Used
- Widgets: User Roles Table, System Health Status, Recent Activity Log
- Quick Actions: Manage Users, View Logs, Configure Permissions

#### ICT Flow 1: Create New User Account

1. **From Dashboard**
   - Click "Manage Users"
   - OR Navigate to Administration → "Manage Users"

2. **Manage Users Page**
   - See list of all users:
     * Name
     * Email
     * Role
     * Status (Active/Inactive)
     * Last Login
     * Action buttons

3. **Click "Add User"**
   - Form dialog opens

4. **Fill User Form**
   - **Name:** Full name of user
   - **Email:** Will be username (must be unique)
   - **Role:** Dropdown
     * Pastor
     * Church Clerk
     * Welfare Director
     * Sabbath School Superintendent
     * Class Coordinator
     * Financial Secretary
     * ICT Administrator
   - **Temporary Password:** Auto-generated or manual
   - **Send Welcome Email:** Checkbox (future feature)

5. **Special Handling for Coordinator Role**
   - If role is "Coordinator":
     * Additional field appears: "Assign to Class"
     * Dropdown of existing classes
     * Must select one class
     * Coordinator assigned to that class

6. **Save User**
   - Click "Create User"
   - Validation:
     * Email unique
     * All required fields filled
     * If coordinator, class selected
   - User created
   - Password hashed and stored
   - Success notification with credentials
   - Activity logged: CREATE_USER

7. **Provide Credentials**
   - Show dialog:
     * Email: [user@church.com]
     * Temporary Password: [password]
     * Instruction to change password on first login
   - ICT admin shares credentials securely with user

#### ICT Flow 2: Manage User Permissions

1. **Navigate to Administration → "Permissions"**

2. **Permissions Page**
   - **What User Sees:**
     - Role selector tabs at top:
       * Pastor
       * Church Clerk
       * Welfare Director
       * Sabbath School Superintendent
       * Class Coordinator
       * Financial Secretary
       * ICT Administrator (greyed out - cannot edit)
   
   - Select a role tab

3. **View/Edit Role Permissions**
   - See permission matrix for selected role:
   
   **Members:**
   - ☐ View Members
   - ☐ Add Members
   - ☐ Edit Members
   - ☐ Delete Members
   
   **Sabbath School:**
   - ☐ View Sabbath School
   - ☐ Manage Classes
   - ☐ Mark Attendance
   
   **Finance:**
   - ☐ View Financial Data
   - ☐ Record Contributions
   - ☐ View Financial Reports
   
   **Reports:**
   - ☐ View Reports
   - ☐ Export Reports
   
   **Settings:**
   - ☐ View Settings
   - ☐ Edit Settings
   
   **Users:**
   - ☐ View Users
   - ☐ Manage Users

4. **Modify Permissions**
   - Check/uncheck boxes
   - Changes preview in real-time
   - Warning shown if removing critical permission

5. **Save Changes**
   - Click "Save Permissions"
   - Confirmation dialog:
     * "This will affect all users with role [Role Name]"
     * "Continue?"
   - Confirm
   - Permissions updated
   - Activity logged: UPDATE_PERMISSIONS
   - All users with that role immediately affected

**Note:** ICT role permissions cannot be modified (always full access)

#### ICT Flow 3: View Activity Logs

1. **Navigate to Administration → "View Logs"**

2. **Activity Logs Page**
   - **Filter Panel:**
     - Date Range (Today, This Week, This Month, Custom)
     - User (dropdown: All users or specific)
     - Role (dropdown: All roles or specific)
     - Action Type (dropdown: All, CREATE, UPDATE, DELETE, LOGIN, EXPORT, etc.)
     - Module (dropdown: All, Members, Finance, Sabbath School, Users, Settings)
   
   - **Search:** Text search in details

3. **Apply Filters**
   - Select desired filters
   - Click "Search" or "Apply Filters"
   - System queries activity logs

4. **View Results**
   - Table with:
     * Timestamp (date and time)
     * User Name
     * User Role
     * Action (e.g., "CREATE_MEMBER")
     * Module
     * Details (expandable)
     * IP Address
   
   - Sortable by any column
   - Pagination (50 per page)

5. **View Details**
   - Click on log entry
   - Expanded view shows:
     * Full details (JSON formatted)
     * Before/after values (if applicable)
     * User agent information
     * Session info

6. **Export Logs**
   - Click "Export"
   - Choose CSV format
   - File downloads
   - Use for auditing, reporting, troubleshooting

#### ICT Flow 4: Monitor System Health

1. **From Dashboard**
   - View "System Health Status" widget
   - See indicators:
     * Database Status: ✓ Connected
     * Backup Status: ✓ Last backup 2 hours ago
     * User Sessions: 8 active
     * Storage: 45% used

2. **Identify Issues**
   - Red indicators show problems
   - Click widget for details

3. **System Settings**
   - Navigate to Settings
   - Configure:
     * Backup schedule
     * Session timeout
     * Email settings (future)
     * System maintenance

#### ICT Flow 5: Reset User Password

1. **Navigate to Manage Users**
   - Find user in list
   - Click "Edit" button

2. **User Edit Form**
   - See user details
   - Click "Reset Password" button

3. **Password Reset Dialog**
   - Auto-generate new password
   - OR Enter custom temporary password
   - Click "Reset"

4. **Confirmation**
   - Success notification with new password
   - Copy password
   - Activity logged: RESET_PASSWORD
   - Provide new password to user

5. **User Next Login**
   - User logs in with new password
   - System prompts to change password (future feature)

---

## Detailed Screen-by-Screen Flows

### Screen 1: Landing Page

**Purpose:** Welcome visitors and provide entry to system

**Layout:**
- **Header Bar:**
  - Left: Logo + Church Name
  - Right: "Sign In" button
  
- **Hero Section:**
  - Large SDA logo (centered)
  - Heading: "Pioneer Seventh-Day Adventist Church"
  - Subheading: "Comprehensive Church Management System"
  - "Access Church System" button
  
- **Features Section:**
  - 3 cards in grid (1 col mobile, 3 col desktop)
  - Each card: Icon, Title, Description
  
- **Footer:**
  - Copyright notice
  - Bible verse

**User Interactions:**
- Click "Sign In" (header) → Login Page
- Click "Access Church System" (hero) → Login Page
- Scroll to read features
- Mobile: Touch-friendly buttons

**Responsive:**
- Mobile: Stacked layout, larger text
- Tablet: 2-column features
- Desktop: Full 3-column layout

---

### Screen 2: Login Page

**Purpose:** Authenticate users

**Layout:**
- **Center Card:**
  - Logo at top
  - "Welcome Back" heading
  - Email input
  - Password input
  - "Sign In" button
  - Optional: "Forgot Password?" link

**Validation:**
- Email format
- Password minimum 8 characters
- Error messages below fields

**User Interactions:**
- Type email
- Type password
- Click "Sign In"
- OR press Enter
- Click "Forgot Password" (future feature)

**States:**
- Default: Empty fields
- Error: Red border, error message
- Loading: Button shows spinner
- Success: Redirect to dashboard

---

### Screen 3: Dashboard (Generic Structure)

**Purpose:** Role-specific home screen with key metrics and quick actions

**Layout:**
- **Header:**
  - Page title: "Dashboard"
  - Optional: Date/time

- **Stats Cards (4 cards in row):**
  - Icon + Metric name + Value + Change indicator
  - Cards responsive: 1 col mobile, 2 col tablet, 4 col desktop

- **Charts Section:**
  - 1-2 charts showing trends
  - Responsive: Full width mobile, side-by-side desktop

- **Widgets/Tables:**
  - Recent items, lists, etc.
  - Scrollable if long

- **Quick Actions:**
  - Prominent buttons for common tasks

**User Interactions:**
- Click stat card → Navigate to related page
- Hover over chart → See tooltips
- Click quick action button → Open that feature
- Scroll to see more content

---

### Screen 4: Member List

**Purpose:** View and manage all church members

**Layout:**
- **Header:**
  - Left: Title + Description
  - Right: "Add Member" button

- **Search & Filter Bar:**
  - Left: Search input (with icon)
  - Right: Status filter dropdown

- **Table:**
  - Columns: Name, Gender, Category, Membership Type, Baptism Status, Status, Actions
  - Sortable headers
  - Pagination at bottom

**Table Features:**
- **Search:** Live filter as user types
- **Filter:** By membership status (all, active, inactive, transferred, archived)
- **Sort:** Click column header to sort
- **Actions:** View, Edit (if permission)

**User Interactions:**
- Type in search → Filter results
- Select status filter → Filter results
- Click column header → Sort
- Click member name or "View" → Member detail page
- Click "Edit" → Edit form (if has permission)
- Click "Add Member" → Add member form

**Responsive:**
- Mobile: Card view (not table)
- Tablet: Scrollable table
- Desktop: Full table

---

### Screen 5: Add/Edit Member Form

**Purpose:** Create new member or edit existing

**Layout:**
- **Header:**
  - Back button (left)
  - Title: "Add New Member" or "Edit Member"

- **Form Sections (Cards):**
  
  **1. Personal Information:**
  - First Name, Last Name, Family Name (3 cols)
  - Gender, Date of Birth (2 cols)
  - Phone, Email (2 cols)
  - Address (full width)
  
  **2. Membership Details:**
  - Membership Type, Category (2 cols)
  - Role in Church (full width)
  - Baptism Status, Date of Baptism (2 cols)
  - Membership Date (full width)
  
  **3. Optional:**
  - Photo upload
  - Sabbath School Class
  
  **4. Actions:**
  - "Cancel" button (secondary)
  - "Save Member" button (primary)

**Validation:**
- Required fields marked with *
- Real-time validation on blur
- Error messages below fields
- Disabled submit if validation fails

**User Interactions:**
- Fill form top to bottom
- Tab between fields
- Select from dropdowns
- Pick dates from calendar
- Upload photo (drag & drop or browse)
- Click "Save Member"
- Click "Cancel" → Confirm dialog, then back

**Responsive:**
- Mobile: All fields full width (1 col)
- Tablet: Some 2 col
- Desktop: 2-3 col grid

---

### Screen 6: Member Detail

**Purpose:** View comprehensive member information

**Layout:**
- **Header:**
  - Back button (left)
  - Member name (center/left)
  - "Edit Member" button (right, if permission)

- **Profile Section:**
  - Left: Photo or placeholder
  - Right: Key info (name, age, contact)

- **Tabs:**
  - Personal Info
  - Membership Details
  - Contribution History
  - Attendance History
  - Transfer Information (if applicable)

- **Tab Content:**
  - Tables, cards, charts depending on tab

**User Interactions:**
- Click tabs → Switch content
- Scroll within tab
- Click "Edit Member" → Edit form
- Click "Add Contribution" → Contribution form
- Click "Transfer Member" → Transfer form
- View charts, tables

**Responsive:**
- Mobile: Stacked layout, tabs scroll horizontally
- Tablet: 2-column where appropriate
- Desktop: Full layout

---

### Screen 7: Transfer Management

**Purpose:** Track member transfers between churches

**Layout:**
- **Header:**
  - Title + Description
  - "Add Transfer" button

- **Tabs:**
  - All Transfers
  - Outgoing (To other churches)
  - Incoming (From other churches)

- **Table:**
  - Columns: Member Name, Direction, Church Name, Transfer Date, Status, Actions
  - Color-coded status badges
  - Action buttons: View, Edit

**Add Transfer Dialog:**
- Modal overlay
- Form with:
  - Member selection (searchable dropdown)
  - Direction (radio buttons)
  - Church name
  - Transfer date
  - Status dropdown
  - Notes textarea
- Save/Cancel buttons

**User Interactions:**
- Click tab → Filter transfers
- Click "Add Transfer" → Open dialog
- Fill form → Save
- Click transfer row → View details
- Click "Edit" → Open edit dialog
- Update status → Auto-update member status

**Responsive:**
- Mobile: Card view for transfers
- Tablet: Scrollable table
- Desktop: Full table view

---

### Screen 8: Sabbath School Hub

**Purpose:** Central navigation for Sabbath School functions

**Layout:**
- **Header:**
  - Title: "Sabbath School"
  - Description: "Manage classes and attendance"

- **Action Cards (4 cards in grid):**
  - Class Management (blue border on hover)
  - Assign Members (green border on hover)
  - Mark Attendance (purple border on hover)
  - Attendance Reports (yellow border on hover)
  
  Each card:
  - Icon (top)
  - Title
  - Description

**User Interactions:**
- Click card → Navigate to that feature
- Hover → Color change, lift effect

**Responsive:**
- Mobile: 1 column (stacked cards)
- Tablet: 2 columns (2x2 grid)
- Desktop: 4 columns (1x4 grid)

---

### Screen 9: Attendance Marking

**Purpose:** Record Sabbath School attendance

**Layout:**
- **Header:**
  - Back button
  - Title: "Mark Attendance"
  - Date selector (right)

- **Class Info:**
  - Class name (auto-loaded for coordinator)
  - Member count

- **Quick Actions:**
  - "Mark All Present" button
  - "Mark All Absent" button

- **Member Table:**
  - Columns: Member Name, Last Attendance, Streak, Present (checkbox), Notes
  - Each row: Member info + checkbox + notes input
  
- **Footer:**
  - "Save Attendance" button (primary)
  - "Cancel" button (secondary)

**User Interactions:**
- Select date (Saturday only)
- Click "Mark All Present" → All checkboxes checked
- Click "Mark All Absent" → All checkboxes unchecked
- Check/uncheck individual boxes
- Enter notes in text fields
- Click "Save Attendance" → Validate and save

**Validation:**
- Date must be Saturday
- Date cannot be future
- Confirmation if large changes

**Responsive:**
- Mobile: Card view for members, checkboxes prominent
- Tablet: Simplified table
- Desktop: Full table view

---

### Screen 10: Record Contributions (Bulk Grid)

**Purpose:** Record contributions for all members by category

**Layout:**
- **Header:**
  - Title: "Record Contributions"
  - Date selector
  - "Save All" button

- **Contribution Grid:**
  - **Vertical scroll:** Members (rows)
  - **Horizontal scroll:** Categories (columns)
  - First column: Member names (fixed)
  - Category columns: Input fields
  - Last column: Row total (calculated)
  - Bottom row: Column totals (calculated)
  - Bottom-right: Grand total

**Grid Features:**
- Sticky header row (categories)
- Sticky first column (member names)
- Sticky bottom row (totals)
- Auto-calculate on input
- Tab navigation between cells
- Enter key moves to next row

**User Interactions:**
- Select date
- Enter amounts in grid cells
- Tab through cells
- Watch totals update
- Review totals
- Click "Save All" → Validate and save

**Validation:**
- Only positive numbers
- Max 2 decimal places
- Date validation

**Success:**
- Notification with count
- Grid clears
- Ready for next entry

**Responsive:**
- Mobile: Difficult - show message to use desktop
- Tablet: Scrollable grid
- Desktop: Optimal view

---

### Screen 11: Financial Reports

**Purpose:** Analyze and export financial data

**Layout:**
- **Header:**
  - Title: "Financial Reports"

- **Filter Panel (Card):**
  - Date range selector
  - Category filter
  - Group by option
  - "Generate Report" button

- **Results Section (appears after generate):**
  
  **Summary Cards (4 cards):**
  - Total Contributions
  - Number of Contributors
  - Average Contribution
  - Largest Single Contribution
  
  **Charts:**
  - Pie Chart: By category
  - Bar Chart: Top contributors
  - Line Chart: Trend over time
  
  **Detailed Table:**
  - All contributions in date range
  - Columns: Date, Member, Category, Amount
  - Sortable, searchable
  - Pagination
  
  **Export Section:**
  - "Export PDF" button
  - "Export Excel" button

**User Interactions:**
- Select filters
- Click "Generate Report"
- View results (scroll through)
- Hover over charts → See tooltips
- Click chart segments → Filter table
- Sort table columns
- Search in table
- Click "Export PDF" → Download
- Click "Export Excel" → Download

**Responsive:**
- Mobile: Stacked layout, simplified charts
- Tablet: 2-column layout
- Desktop: Full layout with side-by-side charts

---

### Screen 12: Manage Users (ICT)

**Purpose:** Manage system user accounts

**Layout:**
- **Header:**
  - Title: "Manage Users"
  - "Add User" button

- **User Table:**
  - Columns: Name, Email, Role, Status, Last Login, Actions
  - Status badges (Active/Inactive)
  - Actions: Edit, Reset Password, Deactivate

**Add/Edit User Dialog:**
- Modal form
- Fields:
  - Name
  - Email
  - Role (dropdown)
  - If Coordinator: Class assignment
  - Password (add only)
- Save/Cancel buttons

**User Interactions:**
- Click "Add User" → Open dialog
- Fill form → Save
- Click "Edit" → Open edit dialog
- Click "Reset Password" → Confirm, generate new password
- Click "Deactivate" → Confirm, deactivate user
- Search users
- Filter by role

**Responsive:**
- Mobile: Card view for users
- Tablet: Scrollable table
- Desktop: Full table

---

### Screen 13: Permissions Configuration (ICT)

**Purpose:** Configure role-based permissions

**Layout:**
- **Header:**
  - Title: "Role Permissions"

- **Role Tabs:**
  - Horizontal tabs for each role
  - Active tab highlighted

- **Permission Matrix:**
  - Grouped by module (Members, Sabbath School, Finance, etc.)
  - Each group has permission checkboxes
  - Visual hierarchy: Module headers, permission items

- **Footer:**
  - "Reset to Default" button
  - "Save Changes" button

**User Interactions:**
- Click role tab → Load permissions for that role
- Check/uncheck permission boxes
- Click "Save Changes" → Confirm, save
- Click "Reset to Default" → Confirm, reset

**Validation:**
- Cannot edit ICT permissions
- Warning if removing critical permissions
- Confirmation before save

**Responsive:**
- Mobile: Tabs scroll horizontally, stacked checkboxes
- Tablet: Side-by-side layout
- Desktop: Full grid layout

---

### Screen 14: Activity Logs (ICT)

**Purpose:** View and audit system activities

**Layout:**
- **Header:**
  - Title: "Activity Logs"

- **Filter Panel:**
  - Date range
  - User dropdown
  - Role dropdown
  - Action dropdown
  - Module dropdown
  - Search field
  - "Apply Filters" button
  - "Export Logs" button

- **Log Table:**
  - Columns: Timestamp, User, Role, Action, Module, Details (truncated)
  - Click row → Expand to see full details
  - Color coding by action type

**User Interactions:**
- Apply filters
- Search logs
- Click log row → Expand/collapse details
- Sort by column
- Paginate through results
- Click "Export Logs" → Download CSV

**Responsive:**
- Mobile: Card view, expand for details
- Tablet: Simplified table
- Desktop: Full table with all columns

---

## Mobile User Experience

### Mobile Navigation Pattern

**Hamburger Menu:**
1. User taps hamburger icon (top-left)
2. Sidebar slides in from left
3. Dark overlay appears
4. Sidebar shows all menu items
5. User taps menu item → Sidebar closes, navigate
6. OR User taps overlay → Sidebar closes, stay on page

**Mobile Navbar:**
- Left: Hamburger icon
- Center: Page title or logo
- Right: Notification bell, User profile

**Bottom Navigation (Alternative):**
- Consider bottom nav bar for frequent actions
- 4-5 icons: Dashboard, Members, Sabbath School, Finance, More

### Mobile-Optimized Screens

**Dashboard:**
- Stats cards: 1 column, full width
- Charts: Full width, scrollable
- Widgets: Stacked vertically

**Lists (Members, etc.):**
- Card view instead of table
- Each card shows key info
- Tap card → Details
- Swipe gestures for actions

**Forms:**
- All inputs full width
- Large touch targets (min 44px)
- Date pickers optimized for mobile
- Dropdowns native mobile style

**Tables:**
- Horizontal scroll for wide tables
- OR Convert to cards
- Sticky headers

**Grids (Contributions):**
- Recommend desktop use
- Mobile: Show message "Use desktop for best experience"
- OR Simplified mobile entry (one member at a time)

### Mobile Gestures

- **Swipe:** Navigate between tabs, delete items
- **Pull to Refresh:** Update data
- **Long Press:** Context menu
- **Pinch:** Zoom charts (optional)

---

## Error Handling and Edge Cases

### Common Error Scenarios

#### 1. Network Errors

**Scenario:** Connection lost during operation

**User Experience:**
- Toast notification: "Connection lost. Please check your internet."
- Operation not completed
- User can retry
- Data entered preserved (if possible)

**Example:**
- User filling form, clicks Save
- Network fails
- Error message shown
- Form data still in fields
- User can save again when connection restored

#### 2. Validation Errors

**Scenario:** User submits invalid data

**User Experience:**
- Form submission prevented
- Red border on invalid fields
- Error message below field
- Focus moved to first invalid field
- Submit button remains enabled (can retry)

**Examples:**
- Email format invalid: "Please enter a valid email address"
- Required field empty: "This field is required"
- Date in future: "Date cannot be in the future"
- Duplicate email: "This email is already registered"

#### 3. Permission Errors

**Scenario:** User tries to access forbidden feature

**User Experience:**
- Option not shown (UI hides based on role)
- If accessed via URL: 
  - Redirect to dashboard
  - Toast: "You don't have permission to access this page"

**Example:**
- Welfare Director tries to add member
- "Add Member" button not visible
- If navigates directly: Redirected, notified

#### 4. Data Not Found

**Scenario:** Trying to view deleted/non-existent record

**User Experience:**
- Page shows "Not Found" message
- "Back to List" button
- Suggest similar records (if applicable)

**Example:**
- Click member link from old bookmark
- Member has been deleted
- "Member not found. They may have been archived."
- Button to return to member list

#### 5. Concurrent Modification

**Scenario:** Two users editing same record

**User Experience:**
- First save succeeds
- Second save shows warning:
  - "This record was modified by [User] at [Time]"
  - Options: "Reload and lose my changes" or "Save anyway"
- Activity log shows both edits

#### 6. Empty States

**Scenario:** No data to display

**User Experience:**
- Friendly message instead of empty table
- Illustration or icon
- Suggestion for what to do
- Call-to-action button

**Examples:**
- No members: "No members found. Add your first member!"
- No contributions: "No contributions recorded for this period."
- No attendance: "No attendance marked yet."

#### 7. Session Timeout

**Scenario:** User inactive for extended period

**User Experience:**
- Warning toast: "Your session will expire in 5 minutes"
- After timeout:
  - Redirected to login
  - Message: "Your session has expired. Please log in again."
  - After login, return to previous page (if possible)

#### 8. File Export Errors

**Scenario:** Export generation fails

**User Experience:**
- Progress indicator while generating
- If fails:
  - Error toast: "Export failed. Please try again."
  - Option to retry
  - Option to use different format
- If too large:
  - Warning: "This report is very large. It may take a few minutes."
  - Option to refine date range

### Edge Cases

#### Member with No Class

**Handling:**
- Member's sabbathSchoolClassId is null
- In attendance: Not shown in any class list
- In reports: Listed under "Unassigned"
- Can still view member, edit, assign to class

#### Class with No Coordinator

**Prevention:**
- System requires coordinator on class creation
- Cannot remove coordinator without assigning new one

**If orphaned:**
- Superintendent can reassign
- Class shown in list with warning icon

#### Contribution with Deleted Category

**Handling:**
- Contribution record preserved
- Category name stored (denormalized)
- Shows in reports with archived category indicator
- Can still export, view

#### Transfer Record with Deleted Member

**Handling:**
- Soft delete preferred (member archived, not deleted)
- Transfer record remains
- Shows in transfer list with archived indicator

#### Attendance for Member Not in Class

**Prevention:**
- System only shows members in that class
- Cannot mark attendance for non-members

**If data mismatch:**
- Report shows inconsistency warning
- ICT can investigate logs

#### Future Dated Records

**Prevention:**
- Validation blocks future dates
- Exception: Baptism status "pending" can have future date

**If somehow saved:**
- Reports flag as unusual
- Admin can review and correct

---

## User Interface Guidelines

### Color Coding System

**Membership Status:**
- Active: Green
- Inactive: Gray
- Transferred: Blue
- Archived: Red

**Baptism Status:**
- Baptized: Green
- Not Baptized: Orange
- Pending: Yellow

**Priority (Notifications):**
- High: Red dot
- Medium: Yellow dot
- Low: Blue dot

**Categories:**
- Adult: Blue
- Youth: Purple
- Child: Pink
- University Student: Green

**Financial Categories:**
- Tithe: Blue
- Offerings: Green
- Donations: Purple
- Other: Gray

### Button Hierarchy

**Primary Actions:**
- Blue background (#2563eb)
- White text
- Examples: Save, Submit, Create

**Secondary Actions:**
- White background
- Gray border
- Gray text
- Examples: Cancel, Back

**Destructive Actions:**
- Red background or text
- Confirmation required
- Examples: Delete, Deactivate

### Icons Usage

**Lucide React Icons:**
- Users: Members, people
- BookOpen: Sabbath School, education
- DollarSign/Coins: Finance, money
- FileText: Reports, documents
- Bell: Notifications
- Settings: Configuration
- Shield: Administration, security
- Calendar: Dates, events
- Search: Search functionality
- Filter: Filtering options
- Eye: View, preview
- Edit: Edit, modify
- Trash: Delete
- Check: Confirm, success
- X: Close, cancel
- ArrowLeft: Back, previous
- ChevronRight: Next, forward
- Download: Export, download

### Typography

**Headings:**
- Page Title: text-2xl (mobile: text-xl)
- Section Heading: text-xl (mobile: text-lg)
- Card Title: text-lg
- Subsection: text-base

**Body Text:**
- Normal: text-base (mobile: text-sm)
- Small: text-sm
- Tiny: text-xs

**Font Weights:**
- Headings: Default (from globals.css)
- Body: Default
- Emphasis: Bold

**Note:** No manual font-size, font-weight, or line-height Tailwind classes unless specifically requested (system uses global typography)

### Spacing

**Layout Spacing:**
- Between sections: space-y-6 (mobile: space-y-4)
- Between cards: gap-6 (mobile: gap-4)
- Card padding: p-6 (mobile: p-4)
- Form field spacing: space-y-4

**Responsive Breakpoints:**
- Mobile: < 768px (sm)
- Tablet: 768px - 1024px (md - lg)
- Desktop: > 1024px (lg+)

### Loading States

**Skeleton Screens:**
- Show layout structure
- Pulsing animation
- Replace with real content when loaded

**Spinners:**
- Use for buttons during submission
- Use for page loading if quick

**Progress Bars:**
- For long operations (exports, uploads)
- Show percentage if possible

### Feedback Messages

**Toast Notifications (Sonner):**
- Success: Green, checkmark icon
- Error: Red, X icon
- Warning: Yellow, alert icon
- Info: Blue, info icon

**Inline Validation:**
- Real-time feedback
- Below input fields
- Red text for errors
- Green for success

### Accessibility

**Keyboard Navigation:**
- Tab through all interactive elements
- Enter to submit forms
- Escape to close dialogs
- Arrow keys in dropdowns

**Screen Reader Support:**
- Semantic HTML (nav, main, article, etc.)
- ARIA labels where needed
- Alt text on images
- Descriptive button text

**Color Contrast:**
- Meets WCAG AA standards
- Text readable on backgrounds
- Error messages distinguishable without color

### Responsive Images

**Member Photos:**
- Square aspect ratio
- Fallback to initials if no photo
- Lazy loading for lists

**Logo:**
- SVG preferred (scales well)
- High-res PNG fallback

---

## Conclusion

This user flow documentation provides a comprehensive guide to every interaction, screen, and decision point in the Church Management System. Use this document to:

- **Train new users** on system navigation and features
- **Design database queries** based on user actions
- **Build UI components** that match user expectations
- **Test user journeys** to ensure smooth experiences
- **Develop API endpoints** that support these flows
- **Create help documentation** for end users
- **Design intuitive interfaces** following established patterns

The flows described here represent the complete user experience from first visit to daily operations, covering all seven user roles and their unique workflows.

---

**Document Version:** 1.2
**Last Updated:** November 10, 2025  
**Companion Document:** DATABASE_DOCUMENTATION.md  
**Application:** Pioneer SDA Church Management System
