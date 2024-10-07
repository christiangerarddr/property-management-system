<?php

namespace App\Services;

use App\Models\Owner;
use Illuminate\Contracts\Pagination\Paginator;
use Tests\TestCase;

class OwnerServiceTest extends TestCase
{
    protected OwnerService $ownerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ownerService = new OwnerService;
    }

    public function test_create_owner()
    {
        $data = [
            'name' => 'Test Owner',
            'contact_info' => 'testowneremail@test.com',
        ];

        $owner = $this->ownerService->createOwner($data);

        $this->assertInstanceOf(Owner::class, $owner);
        $this->assertEquals($data['name'], $owner->name);
        $this->assertEquals($data['contact_info'], $owner->contact_info);
    }

    public function test_get_property_image()
    {
        $owner = Owner::factory()->create();

        $retrievedPropertyImage = $this->ownerService->getOwner($owner->id);

        $this->assertInstanceOf(Owner::class, $retrievedPropertyImage);
        $this->assertEquals($owner->id, $retrievedPropertyImage->id);
    }

    public function test_update_property_image()
    {
        $owner = Owner::factory()->create();

        $updatedData = ['name' => 'Updated Owner'];

        $updatedOwner = $this->ownerService->updateOwner($owner->id, $updatedData);

        $this->assertEquals('Updated Owner', $updatedOwner->name);
        $this->assertEquals($owner->id, $updatedOwner->id);
    }

    public function test_delete_property_image()
    {
        $owner = Owner::factory()->create();

        $deleted = $this->ownerService->deleteOwner($owner->id);

        $this->assertTrue($deleted);
        $this->assertNull(Owner::find($owner->id)); // Assert that the Owner is deleted
    }

    public function test_list_owners()
    {
        Owner::factory()->count(5)->create(['name' => 'Sample Owner']);
        Owner::factory()->count(3)->create(['name' => 'Another Owner']);

        $owners = $this->ownerService->listOwners(['name' => 'Sample Owner']);

        $this->assertCount(5, $owners);
        foreach ($owners as $owner) {
            $this->assertEquals('Sample Owner', $owner->name);
        }
    }

    public function test_list_owners_with_pagination()
    {
        Owner::factory()->count(15)->create(['name' => 'Sample City']);

        $owners = $this->ownerService->listOwners(['name' => 'Sample City'], true, 5);

        $this->assertInstanceOf(Paginator::class, $owners);
        $this->assertCount(5, $owners->items());
        $this->assertEquals(15, $owners->total());
    }
}
