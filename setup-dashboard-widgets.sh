#!/bin/bash
# File: setup-dashboard-widgets.sh
# Make executable: chmod +x setup-dashboard-widgets.sh
# Run: ./setup-dashboard-widgets.sh

echo "🎨 Setting up Filament Dashboard Widgets..."

# Create widgets directory if it doesn't exist
mkdir -p app/Filament/Widgets
mkdir -p app/Filament/Pages
mkdir -p resources/views/filament/widgets

echo "✅ Directories created!"
echo ""
echo "📝 Now copy the widget files from the artifacts:"
echo ""
echo "1. Copy StatsOverviewWidget.php to app/Filament/Widgets/"
echo "2. Copy RecentSubmissionsWidget.php to app/Filament/Widgets/"
echo "3. Copy RecentEventBriefsWidget.php to app/Filament/Widgets/"
echo "4. Copy ProjectsChartWidget.php to app/Filament/Widgets/"
echo "5. Copy QuickActionsWidget.php to app/Filament/Widgets/"
echo "6. Copy quick-actions-widget.blade.php to resources/views/filament/widgets/"
echo "7. Copy Dashboard.php to app/Filament/Pages/"
echo ""
echo "Then run:"
echo "  php artisan filament:optimize"
echo "  php artisan optimize:clear"
echo ""
echo "🎉 After copying files, your dashboard will have:"
echo "  ✅ Quick action buttons"
echo "  ✅ Stats overview cards"
echo "  ✅ Projects chart (doughnut)"
echo "  ✅ Recent contact submissions table"
echo "  ✅ Recent event briefs table"
