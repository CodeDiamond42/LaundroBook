
Process booking test · PHP
<?php
 
// This code is used to call the booking controller and display
// the errors found within the errors array in the booking controller.
//
// UPDATED: bookingController's constructor now requires five
// dependencies (four repo interfaces + AvailabilityService), since
// it also handles booking creation now, not just validation. Since
// this test is only exercising validate_input(), none of the real
// repository logic actually gets called - so instead of building real
// repos (which would need a live database connection), we hand it
// stub classes that satisfy each interface with harmless fake data.
// If you're only testing validation here, what these stubs return
// doesn't matter at all - they just need to exist so PHP's type
// hints are satisfied and the constructor doesn't reject them.
 
require_once __DIR__ . '/../Interfaces/Repositoryinterfaces.php';
require_once __DIR__ . '/../Services/AvailabilityService.php';
require_once __DIR__ . '/../Controllers/bookingController.php';
 
class StubMachineRepo implements MachineRepoInterface
{
    public function getAvailableMachines(): array { return []; }
    public function getMachineById(int $machineId): ?array { return null; }
    public function updateStatus(int $machineId, string $status): bool { return true; }
    public function machineExists(int $machineId): bool { return true; }
}
 
class StubSlotRepo implements SlotRepoInterface
{
    public function getActiveSlots(): array { return []; }
    public function getSlotById(int $slotId): ?array { return null; }
}
 
class StubCustomerRepo implements CustomerRepoInterface
{
    public function findByEmail(string $email): ?Customer { return null; }
    public function createCustomer(string $name, string $email, string $phone, string $address): Customer
    {
        return new Customer(1, $name, $email, $phone, $address);
    }
    public function findOrCreate(array $data): Customer
    {
        return new Customer(1, $data['customer_name'], $data['customer_email'], $data['customer_phone'], $data['delivery_address'] ?? '');
    }
}
 
class StubBookingRepo implements BookingRepoInterface
{
    public function insert(int $customerId, int $managerId, array $service, array $data): int { return 1; }
    public function getBookedCombosForDate(string $bookingDate): array { return []; }
    public function getPrimaryManager(): array { return ['manager_id' => 1]; }
    public function findBooking(int $bookingId): ?array { return null; }
}
 
class StubServiceRepo implements ServiceRepoInterface
{
    public function findByType(string $washType, string $loadType): ?array { return null; }
    public function getServiceById(int $serviceId): ?array { return null; }
}
 
$machineRepo = new StubMachineRepo();
$slotRepo = new StubSlotRepo();
$customerRepo = new StubCustomerRepo();
$bookingRepo = new StubBookingRepo();
$serviceRepo = new StubServiceRepo();
 
$availability = new AvailabilityService($machineRepo, $slotRepo, $bookingRepo);
 
$controller = new bookingController($machineRepo, $customerRepo, $bookingRepo, $serviceRepo, $availability);
 
if ($controller->validate_input()) {
    echo "<h2>Validation passed!</h2>";
    echo "<pre>";
    print_r($controller->getData());
    echo "</pre>";
} else {
    echo "<h2>Validation failed:</h2>";
    echo "<ul>";
    foreach ($controller->getErrors() as $error) {
        echo "<li>" . $error . "</li>";
    }
    echo "</ul>";
}
 
