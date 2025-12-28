# TODO List for Making Todo-App Error-Free and Best UI

## Error Fixes (Priority)
- [x] Fix SQL injection in tasks/toggle.php: Add user ownership checks and prepared statements
- [x] Fix SQL injection in tasks/delete.php: Add user ownership checks and prepared statements
- [x] Update dashboard.php to use prepared statements for queries
- [ ] Move DB credentials to environment variables in config/db.php
- [ ] Install PhpSpreadsheet for export_excel.php if needed
- [ ] Add input validation in forms (register.php, login.php, add task in dashboard.php)

## UI Enhancements
- [ ] Enhance style.css with better animations, transitions, icons
- [ ] Improve responsive design in style.css
- [ ] Add AJAX for task operations (add, toggle, delete) to avoid reloads
- [ ] Implement loading states, real-time validation
- [ ] Enhance dark mode, add search/filter, drag-and-drop (basic)
- [ ] Improve accessibility

## Followup steps
- [ ] Test app functionality
- [ ] Install dependencies if required
