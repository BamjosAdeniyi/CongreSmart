import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { DollarSign, TrendingUp, PieChart as PieChartIcon, FileText } from 'lucide-react';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';

const monthlyData = [
  { month: 'Jun', tithe: 14000, offerings: 4500, projects: 6000 },
  { month: 'Jul', tithe: 15500, offerings: 5200, projects: 7500 },
  { month: 'Aug', tithe: 14800, offerings: 4800, projects: 7000 },
  { month: 'Sep', tithe: 16000, offerings: 5500, projects: 8500 },
  { month: 'Oct', tithe: 15000, offerings: 5000, projects: 8000 },
];

export function FinancialDashboard() {
  return (
    <div className="space-y-6">
      <div>
        <h1 className="text-2xl text-gray-900">Financial Secretary Dashboard</h1>
        <p className="text-gray-500">Financial overview and contribution tracking</p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm">Total This Month</CardTitle>
            <DollarSign className="h-4 w-4 text-blue-600" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl">₦31,000</div>
            <p className="text-xs text-gray-500">October 2025</p>
          </CardContent>
        </Card>

        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm">Tithe</CardTitle>
            <TrendingUp className="h-4 w-4 text-green-600" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl">₦15,000</div>
            <p className="text-xs text-gray-500">48% of total</p>
          </CardContent>
        </Card>

        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm">Building Fund</CardTitle>
            <PieChartIcon className="h-4 w-4 text-yellow-600" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl">₦8,000</div>
            <p className="text-xs text-gray-500">26% of total</p>
          </CardContent>
        </Card>

        <Card>
          <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle className="text-sm">Contributors</CardTitle>
            <FileText className="h-4 w-4 text-purple-600" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl">89</div>
            <p className="text-xs text-gray-500">This month</p>
          </CardContent>
        </Card>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Monthly Contribution Trends</CardTitle>
        </CardHeader>
        <CardContent>
          <ResponsiveContainer width="100%" height={350}>
            <BarChart data={monthlyData}>
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis dataKey="month" />
              <YAxis />
              <Tooltip />
              <Legend />
              <Bar dataKey="tithe" fill="#3b82f6" name="Tithe" />
              <Bar dataKey="offerings" fill="#10b981" name="Offerings" />
              <Bar dataKey="projects" fill="#f59e0b" name="Projects" />
            </BarChart>
          </ResponsiveContainer>
        </CardContent>
      </Card>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <Card>
          <CardHeader>
            <CardTitle>Recent Contributions</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="space-y-3">
              <div className="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                <div>
                  <p className="text-sm">John Smith</p>
                  <p className="text-xs text-gray-500">Tithe</p>
                </div>
                <div className="text-right">
                  <p className="text-sm">₦500</p>
                  <p className="text-xs text-gray-500">Oct 18</p>
                </div>
              </div>
              <div className="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                <div>
                  <p className="text-sm">Mary Johnson</p>
                  <p className="text-xs text-gray-500">Tithe</p>
                </div>
                <div className="text-right">
                  <p className="text-sm">₦350</p>
                  <p className="text-xs text-gray-500">Oct 18</p>
                </div>
              </div>
              <div className="flex justify-between items-center p-3 bg-yellow-50 rounded-lg">
                <div>
                  <p className="text-sm">David Williams</p>
                  <p className="text-xs text-gray-500">Building Fund</p>
                </div>
                <div className="text-right">
                  <p className="text-sm">₦100</p>
                  <p className="text-xs text-gray-500">Oct 18</p>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle>Quick Actions</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="space-y-2">
              <button className="w-full text-left p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                <p className="text-sm">Record Contribution</p>
                <p className="text-xs text-gray-500">Add new contribution entry</p>
              </button>
              <button className="w-full text-left p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                <p className="text-sm">Financial Report</p>
                <p className="text-xs text-gray-500">View detailed reports</p>
              </button>
              <button className="w-full text-left p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                <p className="text-sm">Manage Categories</p>
                <p className="text-xs text-gray-500">Add or edit categories</p>
              </button>
              <button className="w-full text-left p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors">
                <p className="text-sm">Export Data</p>
                <p className="text-xs text-gray-500">Download Excel/PDF report</p>
              </button>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  );
}
