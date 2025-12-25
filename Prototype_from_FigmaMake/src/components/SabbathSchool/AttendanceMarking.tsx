import { useState } from 'react';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { Button } from '../ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../ui/table';
import { Checkbox } from '../ui/checkbox';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '../ui/select';
import { Label } from '../ui/label';
import { Calendar, Save, Users } from 'lucide-react';
import { mockMembers, mockClasses } from '../../lib/mockData';

export function AttendanceMarking() {
  const [selectedClass, setSelectedClass] = useState('1');
  const [selectedDate, setSelectedDate] = useState(new Date().toISOString().split('T')[0]);
  const [attendance, setAttendance] = useState<Record<string, boolean>>({});

  const classMembers = mockMembers.filter(m => m.sabbathSchoolClass === selectedClass);
  const selectedClassInfo = mockClasses.find(c => c.id === selectedClass);

  const handleAttendanceToggle = (memberId: string, present: boolean) => {
    setAttendance(prev => ({ ...prev, [memberId]: present }));
  };

  const handleSave = () => {
    console.log('Saving attendance:', { selectedClass, selectedDate, attendance });
    alert('Attendance saved successfully!');
  };

  const presentCount = Object.values(attendance).filter(Boolean).length;

  return (
    <div className="space-y-4 md:space-y-6">
      <div>
        <h1 className="text-xl md:text-2xl text-gray-900">Mark Attendance</h1>
        <p className="text-sm md:text-base text-gray-500">Record Sabbath School class attendance</p>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Attendance Details</CardTitle>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="space-y-2">
              <Label htmlFor="class">Select Class</Label>
              <Select value={selectedClass} onValueChange={setSelectedClass}>
                <SelectTrigger id="class">
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  {mockClasses.map((cls) => (
                    <SelectItem key={cls.id} value={cls.id}>
                      {cls.name} ({cls.memberCount} members)
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>
            <div className="space-y-2">
              <Label htmlFor="date">Date</Label>
              <div className="relative">
                <Calendar className="absolute left-3 top-3 h-4 w-4 text-gray-400" />
                <input
                  id="date"
                  type="date"
                  value={selectedDate}
                  onChange={(e) => setSelectedDate(e.target.value)}
                  className="w-full pl-10 pr-3 py-2 border border-gray-200 rounded-md"
                />
              </div>
            </div>
          </div>

          {selectedClassInfo && (
            <div className="p-4 bg-blue-50 rounded-lg">
              <div className="flex items-center gap-2 mb-2">
                <Users className="w-4 h-4 text-blue-600" />
                <span className="text-sm">Class Information</span>
              </div>
              <p className="text-sm">Coordinator: {selectedClassInfo.coordinatorName}</p>
              <p className="text-sm">Total Members: {selectedClassInfo.memberCount}</p>
              <p className="text-sm">Present Today: {presentCount} / {classMembers.length}</p>
            </div>
          )}
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Class Members</CardTitle>
        </CardHeader>
        <CardContent>
          <div className="border rounded-lg">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead className="w-12">Present</TableHead>
                  <TableHead>Name</TableHead>
                  <TableHead>Category</TableHead>
                  <TableHead>Contact</TableHead>
                  <TableHead>Notes</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {classMembers.map((member) => (
                  <TableRow key={member.id}>
                    <TableCell>
                      <Checkbox
                        checked={attendance[member.id] || false}
                        onCheckedChange={(checked) => handleAttendanceToggle(member.id, checked as boolean)}
                      />
                    </TableCell>
                    <TableCell>
                      <div>
                        <p className="text-sm">{member.firstName} {member.lastName}</p>
                        <p className="text-xs text-gray-500">{member.familyName}</p>
                      </div>
                    </TableCell>
                    <TableCell className="text-sm capitalize">{member.membershipCategory}</TableCell>
                    <TableCell className="text-sm">{member.phone}</TableCell>
                    <TableCell>
                      <input
                        type="text"
                        placeholder="Add note..."
                        className="w-full px-2 py-1 text-sm border border-gray-200 rounded"
                      />
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>

          <div className="mt-6 flex justify-end gap-4">
            <Button variant="outline">
              Cancel
            </Button>
            <Button onClick={handleSave} className="bg-blue-600 hover:bg-blue-700">
              <Save className="w-4 h-4 mr-2" />
              Save Attendance
            </Button>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
