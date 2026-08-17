document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("bookingForm");
    const bookingBtn = document.getElementById("booking_button");
    const confirmBtn = document.getElementById("confirmBookingBtn");
    const validationMessage = document.getElementById("validationMessage");
    const collectionMethod = document.getElementById("collection_method");
    const addressSection = document.getElementById("addressSection");
    const availabilitySection = document.getElementById("availabilitySection");

    //pricing data (static json, avoiding db calls)
    let pricingData = null; 

    async function loadPricingData(){
        if(pricingData) return pricingData;

        try {
            const response = await fetch("/JS/prices.json"); 
            //probably unnecessary check since a string can be written to console
            if(!response.ok) throw new Error(`HTTP ${response.status}`); 
            pricingData = await response.json(); 
        } catch (error) {
            console.error("Failed to load pricing data: ", error); 
            pricingData = null; 
        }

        return pricingData; 
    }

    function getPrice(washType, loadType){
        if(!pricingData) return undefined; 
        const key = `${washType}_${loadType}`;
        return pricingData[key];  
    }



    // =========================================================
    // SHOW/HIDE DELIVERY ADDRESS
    // =========================================================
    collectionMethod.addEventListener("change", function () {
        if (this.value === "delivery") {
            addressSection.classList.remove("hidden");
        } else {
            addressSection.classList.add("hidden");
        }
    });

    // =========================================================
    // BOOK NOW - CLIENT-SIDE VALIDATION
    //
    // If validation passes, reveal the availability section.
    // Price and duration are left empty for PHP to populate
    // from the Service table using wash_type + load_type.
    // =========================================================
    bookingBtn.addEventListener("click", function () {
        const errors = [];

        // --- CUSTOMER INFORMATION ---

        const name = document.getElementById("customer_name").value.trim();
        if (!name) {
            errors.push("Full name is required.");
        } else if (name.length < 2) {
            errors.push("Full name must be at least 2 characters.");
        }

        const email = document.getElementById("customer_email").value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            errors.push("Email address is required.");
        } else if (!emailRegex.test(email)) {
            errors.push("Please enter a valid email address.");
        }

        // Phone - NUMBERS ONLY
        const phone = document.getElementById("customer_phone").value.trim();
        const phoneRegex = /^[0-9]+$/;
        if (!phone) {
            errors.push("Phone number is required.");
        } else if (!phoneRegex.test(phone)) {
            errors.push("Phone number must contain numbers only (no letters or special characters).");
        } else if (phone.length < 7 || phone.length > 15) {
            errors.push("Phone number must be between 7 and 15 digits.");
        }

        // --- BOOKING INFORMATION ---

        const bookingDate = document.getElementById("booking_date").value;
        if (!bookingDate) {
            errors.push("Booking date is required.");
        } else {
            const selected = new Date(bookingDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (selected < today) {
                errors.push("Booking date cannot be in the past.");
            }
        }

        const washType = document.getElementById("wash_type").value;
        if (!washType) {
            errors.push("Please select a wash type.");
        }

        const loadType = document.getElementById("load_type").value;
        if (!loadType) {
            errors.push("Please select a load type.");
        }

        const collection = collectionMethod.value;
        if (!collection) {
            errors.push("Please select a collection method.");
        }

        if (collection === "delivery") {
            const deliveryAddress = document.getElementById("address").value.trim();
            if (!deliveryAddress) {
                errors.push("Delivery address is required for home delivery.");
            }
        }

        // =========================================================
        // SHOW ERRORS OR REVEAL AVAILABILITY SECTION
        // =========================================================
        if (errors.length > 0) {
            validationMessage.innerHTML =
                "<ul>" + errors.map(e => "<li>" + e + "</li>").join("") + "</ul>";
            validationMessage.classList.add("error");
            validationMessage.classList.remove("hidden");
            validationMessage.scrollIntoView({ behavior: "smooth" });
            availabilitySection.classList.add("hidden");

        } else {
            validationMessage.innerHTML = "";
            validationMessage.classList.remove("error");
            validationMessage.classList.add("hidden");

            // Populate summary with user selections
            document.getElementById("selectedWashType").textContent =
                washType.charAt(0).toUpperCase() + washType.slice(1);
            document.getElementById("selectedLoadType").textContent =
                loadType.charAt(0).toUpperCase() + loadType.slice(1);
            document.getElementById("selectedBookingDate").textContent = bookingDate;
            document.getElementById("selectedCollectionMethod").textContent =
                collection === "pickup" ? "Self Pickup" : "Home Delivery";

            // Price and Duration are left for PHP to populate
            // from the Service table. Do not set these in JS.
            // PHP will query: WHERE wash_type = ? AND load_type = ?
            // and populate #servicePrice and #serviceDuration.

            // Show availability section
            availabilitySection.classList.remove("hidden");
            availabilitySection.scrollIntoView({ behavior: "smooth" });
        }
    });

    // =========================================================
    // CONFIRM BOOKING
    //
    // Validates machine and slot selection, then submits
    // the form to PHP for final processing.
    // =========================================================
    confirmBtn.addEventListener("click", function () {
        const machine = document.getElementById("machineSelect").value;
        const slot = document.getElementById("slotSelect").value;

        if (!machine || !slot) {
            validationMessage.innerHTML =
                "<ul><li>Please select both a washing machine and a time slot.</li></ul>";
            validationMessage.classList.add("error");
            validationMessage.classList.remove("hidden");
            validationMessage.scrollIntoView({ behavior: "smooth" });
            return;
        }

        // Validation passed - submit form to PHP for booking creation
        validationMessage.innerHTML = "";
        validationMessage.classList.add("hidden");
        form.submit();
    });

});
