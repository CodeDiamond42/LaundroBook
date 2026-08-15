<?php
    class bookingController{
        /*
            behaviors within this controller:
            -> validate input
            -> check for slot availability (only future slots where start_time >= current time)
            -> check for machine availability (machine_status = available)
            -> check consecutive slot availability if duration_slots = 2 (Heavy Wash)
            -> create customer if they don't exist
            -> fetch service (price + duration_minutes + duration_slots)
            -> derive manager_id
            -> calculate total_price
            -> generate booking_reference
            -> set initial status to Pending
            -> begin transaction
                -> insert booking record
                -> if duration_slots = 2, insert second booking record for consecutive slot
                -> update machine status to in_use
            -> commit transaction
            -> send confirmation email
            -> return confirmation to booking page



        */
        public function validate_input(){
            if($_POST){
            //error handling as a backup could be implemented server-side
            //in case the JS missed something in frontend
            //we also need to perform data sanitization to prevent XSS
            //this has to be done for all inputs

            //inputs:
            $customer_name = $_POST['customer_name'];
            $customer_email = $_POST['customer_email'];
            $customer_phone = $_POST['customer_phone']; 
            

            
            //selects: 
            $booking_date = $_POST['booking_date'];
            $wash_type = $_POST['wash_type'];
            $load_type = $_POST['load_type']; 
            $collection_method = $_POST["collection_method"]; 
            $delivery_address = $_POST['delivery_address'];
            $machine_number = $_POST["machine_id"];
            $slot_time = $_POST['slot_id'];


            



            //next would be to check all of the other fields before
            //we create the booking object. Entities such as slots, 
            //machine etc. 
            //these need to be free, otherwise, we won't create the 
            //booking object successfully
            //we will not be accessing them directly
            //instead we will use their controllers, which will then
            //lead us to the repositories which holds all the SQL queries
            //associated with that particular controller
            //for example: customerController -> customerRepository -> Database
            //and then the db sends back a result which can then be displayed 



        }
        }
    };