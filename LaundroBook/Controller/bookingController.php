<?php
    class bookingController{
        /*
            behaviors within this controller: 
            -> validate input
            -> check for machine availability
            -> check for slot availability
            -> create customer if they don't exist
            -> fetch service (price + duration)
            -> Derive manager_id
            -> Calculate total_price
            -> Calculate machine_free_at (start time + service duration)
            -> Generate booking_reference
            -> Set initial status
            -> Begin transaction (create booking object) → insert booking → update machine's free_at → commit
            -> Return confirmation to booking page



        */
        public function validate_input(){
            if($_POST){
            //error handling as a backup could be implemented server-side
            //in case the JS missed something in frontend
            //we also need to perform data sanitization to prevent XSS
            //this has to be done for all inputs
            $branch = $_POST["branch"]; 
            $booking_date = $_POST["booking_date"]; 
            $booking_time = $_POST["booking_time"]; 
            $machine_number = $_POST["machine_number"]; 
            $service_type = $_POST["service_type"]; 
            $collection_method = $_POST["collection_method"]; 
            $delivery_address = $_POST["delivery_address"];


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





