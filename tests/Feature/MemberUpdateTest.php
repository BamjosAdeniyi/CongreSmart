<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_details_can_be_updated_by_clerk()
    {
        $clerk = User::factory()->create(['role' => 'clerk']);
        $member = Member::factory()->create([
            'first_name' => 'Original',
            'last_name' => 'Name',
            'membership_status' => 'active',
        ]);

        $response = $this->actingAs($clerk)
            ->put(route('members.update', $member), [
                'first_name' => 'Updated',
                'middle_name' => $member->middle_name,
                'last_name' => 'Member',
                'family_name' => 'NewFamily',
                'gender' => 'male',
                'phone' => '1234567890',
                'email' => 'updated@example.com',
                'address' => 'Updated Address',
                'date_of_birth' => '1990-01-01',
                'membership_type' => 'community',
                'membership_category' => 'adult',
                'baptism_status' => 'baptized',
                'date_of_baptism' => '2010-01-01',
                'membership_date' => '2020-01-01',
                'membership_status' => 'inactive',
            ]);

        $response->assertRedirect(route('members.show', $member));

        $member->refresh();
        $this->assertEquals('Updated', $member->first_name);
        $this->assertEquals('Member', $member->last_name);
        $this->assertEquals('inactive', $member->membership_status);

        $response = $this->get(route('members.index'));
        $response->assertStatus(200);
        $response->assertSee('Updated Member');
        $response->assertSee('Inactive');
    }
}
