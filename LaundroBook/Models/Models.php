<?php

class Customer{
    private $customer_id;
    private $customer_name;
    private $customer_email;
    private $customer_phone;
    private $customer_address;

    public function __construct($id, $name, $email, $phone, $address)
    {
        $this->customer_id = $id;
        $this->customer_name = $name;
        $this->customer_email = $email;
        $this->customer_phone = $phone;
        $this->customer_address = $address;
    }

    public function getCustomerId(){
        return $this->customer_id;
    }

    public function printCustomerDetails()
    {
        echo "Customer id: " . $this->customer_id . "<br>";
        echo "Customer name: " . $this->customer_name . "<br>";
        echo "Customer email: " . $this->customer_email . "<br>";
        echo "Customer phone: " . $this->customer_phone . "<br>";
        echo "Customer address: " . $this->customer_address;
    }
}

class Booking
{
    private $booking_id;
    private $customer_id;
    private $machine_id;
    private $slot_id;
    private $service_id;
    private $manager_id;
    private $booking_reference;
    private $booking_date;
    private $total_price;
    private $status;
 
    public function __construct(
        $booking_id,
        $customer_id,
        $machine_id,
        $slot_id,
        $service_id,
        $manager_id,
        $booking_reference,
        $booking_date,
        $total_price,
        $status
    ) {
        $this->booking_id = $booking_id;
        $this->customer_id = $customer_id;
        $this->machine_id = $machine_id;
        $this->slot_id = $slot_id;
        $this->service_id = $service_id;
        $this->manager_id = $manager_id;
        $this->booking_reference = $booking_reference;
        $this->booking_date = $booking_date;
        $this->total_price = $total_price;
        $this->status = $status;
    }
 
    public function getBookingId()
    {
        return $this->booking_id;
    }
 
    public function getBookingReference()
    {
        return $this->booking_reference;
    }
 
    public function printBookingDetails()
    {
        echo "Booking reference: " . $this->booking_reference . "<br>";
        echo "Booking date: " . $this->booking_date . "<br>";
        echo "Total price: R" . $this->total_price . "<br>";
        echo "Status: " . $this->status;
    }
}

class Slot
{
    private $slot_id;
    private $manager_id;
    private $slot_label;
    private $start_time;
    private $end_time;
    private $is_active;

    public function __construct(
        $slot_id,
        $manager_id,
        $slot_label,
        $start_time,
        $end_time,
        $is_active
    ) {
        $this->slot_id = $slot_id;
        $this->manager_id = $manager_id;
        $this->slot_label = $slot_label;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->is_active = $is_active;
    }

    public function getSlotId()
    {
        return $this->slot_id;
    }

    public function getSlotLabel()
    {
        return $this->slot_label;
    }

    public function printSlotDetails()
    {
        echo "Slot: " . $this->slot_label . "<br>";
        echo "Start time: " . $this->start_time . "<br>";
        echo "End time: " . $this->end_time . "<br>";
        echo "Active: " . ($this->is_active ? "Yes" : "No");
    }
}

class Delivery{

    private $delivery_id; 
    private $booking_id; 
    private $groundworker_id; 
    private $delivery_type; 
    private $delivery_status; 
    private $scheduled_time; 


    public function __construct($delivery_id, $booking_id, $groundworker_id, $delivery_type
        , $delivery_status, $scheduled_time){
        $this->delivery_id = $delivery_id; 
        $this->booking_id = $booking_id; 
        $this->groundworker_id = $groundworker_id; 
        $this->delivery_type = $delivery_type;
        $this->delivery_status = $delivery_status; 
        $this->scheduled_time = $scheduled_time; 
    }

    public function getDeliveryId(){
        return $this->delivery_id;
    }

    public function getDeliveryStatus(){
        return $this->delivery_status;
    }

}

class Machine{
    private $machine_id; 
    private $manager_id; 
    private $machine_name; 
    private $machine_status; 

    public function __construct($machine_id, $manager_id, $machine_name, $machine_status){
        $this->machine_id = $machine_id;
        $this->manager_id = $manager_id;
        $this->machine_name = $machine_name;
        $this->machine_status = $machine_status;
    }

    public function getMachineId(){
        return $this->machine_id;
    }

    public function getMachineStatus(){
        return $this->machine_status;
    }
}

class SystemManager{
    private $manager_id; 
    private $username; 
    private $password_hash; 


        
    public function __construct($manager_id, $username, $password_hash){
        $this->manager_id = $manager_id;
        $this->username = $username; 
        $this->password_hash = $password_hash; 
    }

    public function getId(){
        return $this->manager_id; 
    }

}

class GroundWorker{
    private $groundworker_id; 
    private $groundworker_name; 
    private $groundworker_phone; 
    private $groundworker_role; 

    public function __construct($groundworker_id, $groundworker_name, $groundworker_phone, $groundworker_role){
        $this->groundworker_id = $groundworker_id; 
        $this->groundworker_name = $groundworker_name; 
        $this->groundworker_phone = $groundworker_phone; 
        $this->groundworker_role = $groundworker_role; 
    }

    public function getGroundworkerId(){
        return $this->groundworker_id;
    }
    
}

class Service{
    private $service_id; 
    private $manager_id; 
    private $wash_type; 
    private $load_type; 
    private $price; 
    private $duration_minutes; 
    private $duration_slots;

    public function __construct($service_id, $manager_id, $wash_type
        , $load_type, $price, $duration_minutes, $duration_slots){
        $this->service_id = $service_id; 
        $this->manager_id = $manager_id; 
        $this->wash_type = $wash_type; 
        $this->load_type = $load_type; 
        $this->price = $price; 
        $this->duration_minutes = $duration_minutes; 
        $this->duration_slots = $duration_slots; 
    }

    public function __toString(){
        return "Service id: ". $this->service_id . "<br>".
        "Manager id: ". $this->manager_id . "<br>". 
        "Wash type: " . $this->wash_type . "<br>". 
        "Load type: " . $this->load_type . "<br>". 
        "Price: " . $this->price . "<br>" . 
        "Duration in mins: " . $this->duration_minutes. "<br>". 
        "Duration slots: " . $this->duration_slots; 
    }

}