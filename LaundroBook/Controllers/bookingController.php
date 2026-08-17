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
        private $errors = []; // array for errors
        private $data = []; // array for validated form inputs

        public function validate_input(){
            //error handling as a backup could be implemented server-side
            //in case the JS missed something in frontend
            //we also need to perform data sanitization to prevent XSS
            //this has to be done for all inputs
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

            

            if(!$_POST){
                $this->errors[] = "No data submitted";
                return false;
            }

            //inputs:
            $customer_name = $this->sanitize($_POST['customer_name'] ?? '');
            $customer_email = $this->sanitize($_POST['customer_email'] ?? '');
            $customer_phone = $this->sanitize($_POST['customer_phone'] ?? ''); 
            

            
            //selects: 
            $booking_date = $this->sanitize($_POST['booking_date'] ?? '');
            $wash_type = $this->sanitize($_POST['wash_type'] ?? '');
            $load_type = $this->sanitize($_POST['load_type'] ?? ''); 
            $collection_method = $this->sanitize($_POST["collection_method"] ?? ''); 
            $machine_number = $this->sanitize($_POST["machine_id"] ?? '');
            $slot_time = $this->sanitize($_POST['slot_id'] ?? '');

            if($collection_method == "delivery"){
                $delivery_address = $this->sanitize($_POST['delivery_address'] ?? '');

                if(empty($delivery_address)){
                    $this->errors[] = "Address is required";
                }

            }


            //customer information validation:

            if(empty($customer_name)){
                $this->errors[] = "Full name is required";
            }
            else if(strlen($customer_name) < 2){
                $this->errors[] = "Full name must be more than 2 characters";
            }
            else if(!preg_match("/^[a-zA-Z\s\-'.]+$/", $customer_name)){
                $this->errors[] = "Full name must only conatin letters";
            }


            if(empty($customer_email)){
                $this->errors[] = "Email is required";
            }
            else if(!filter_var($customer_email, FILTER_VALIDATE_EMAIL)){
                $this->errors[] = "Please enter a valid email address";
            }


            if(empty($customer_phone)){
                $this->errors[] = "Phone number is required";
            }
            else if(!preg_match("/^[0-9]+$/", $customer_phone)){
                $this->errors[] = "Phone numbers must only contain numbers";
            }
            else if(strlen($customer_phone) != 10){
                $this->errors[] = "Phone number must be 10 digits";
            }


            //booking information validation:

            if(empty($booking_date)){
                $this->errors[] = "Booking data is required";
            }
            else if(!$this->is_valid_date($booking_date)){
                $this->errors[] = "Booking date format is invalid";
            }
            else{
                $today = new DateTime('today');
                $selected = DateTime::createFromFormat('Y-m-d', $booking_date);
                if($selected < $today){
                    $this->errors[] = "Booking date cannot be in the past";
                }
            }


            $valid_wash_types = ['quick', 'normal', 'heavy'];
            if(empty($wash_type) || !in_array($wash_type, $valid_wash_types, true)){
                $this->errors[] = "Please select a valid wash type";
            }


            $valid_load_types = ['clothes', 'beddings', 'towels'];
            if(empty($load_type) || !in_array($load_type, $valid_load_types, true)){
                $this->errors[] = "Please select a valid load type";
            }

            
            $valid_collection = ['pickup', 'delivery'];
            if(empty($collection_method) || !in_array($collection_method, $valid_collection, true)){
                $this->errors[] = "Please select a valid collection method";
            }


            if(empty($machine_number) || !ctype_digit((string)$machine_number)){
                $this->errors[] = "A valid machine selection is required";
            }


            if(empty($slot_time) || !ctype_digit((string)$slot_time)){
                $this->errors[] = "A valid time slot selection is required";
            }


            if(!empty($this->errors)){
                return false;
            }


            //Stashing the clean data for future steps before the function ends, prevents going through whole $_POST submission -
            // where users can enter unsanitized data, leading to duplicated sanitization process.
            $this->data = compact(
                'customer_name', 'customer_email', 'customer_phone',
                'booking_date', 'wash_type', 'load_type', 'collection_method',
                'delivery_address', 'machine_number', 'slot_time'
            );


            return true;

        }

        //sanitization function
        private function sanitize($value){
            return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
        }

        //valid date check function
        private function is_valid_date($date, $format = 'Y-m-d'){
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) === $date;
        }

        public function getErrors(){
            return $this->errors;
        }

        public function getData(){
            return $this->data;
        }


    };