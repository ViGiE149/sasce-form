//const { update } = require("firebase/database");

document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    const submitButton = document.querySelector('button[type="submit"]');

    // Function to check if the email exists and fill in the form
    function checkEmail() {
        const email = emailInput.value.trim();

        if (email) {
            fetch('check_email.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ email: email }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(
                            `HTTP error! status: ${response.status}`
                        );
                    }
                    return response.json(); // This ensures the JSON is parsed correctly
                })
                .then((data) => {
                    console.log(data);
                    //console.log(data);
                    if (data.exists) {
                        // Populate fields with existing data
                        document.getElementById('name').value = (
                            data.name || ''
                        ).trim();
                        document.getElementById('title').value = (
                            data.title || ''
                        ).trim();
                        document.getElementById('institution').value = (
                            data.institution || ''
                        ).trim();
                        document.getElementById('official_email').value = (
                            data.officialEmail || ''
                        ).trim();
                        document.getElementById('phone').value = (
                            data.phone || ''
                        ).trim();
                        document.getElementById('office_number').value = (
                            data.office_number || ''
                        ).trim();
                        //document.getElementById('membership').value = (data.membershipType || '').trim();
                        //document.getElementById('exhibitor').value = (data.exhibitor || '').trim();
                        document.getElementById('workshop').value = (
                            data.workshop || ''
                        ).trim();
                        //document.getElementById('abstract').value = (data.abstract || '').trim();
                        //document.getElementById('subtheme').value = (data.subtheme || '').trim();
                        //document.getElementById('motivation').value = (data.motivation || '').trim();
                        //document.getElementById('topic').value = (data.topic || '').trim();
                        //document.getElementById('responsible_payment').value = (data.responsible_payment || '').trim();
                        //document.getElementById('invoice_contact').value = (data.invoice_contact || '').trim();
                        document.getElementById('accommodation').value = (
                            data.accommodation || ''
                        ).trim();
                        document.getElementById('poster_presenting').value = (
                            data.poster_presenting || ''
                        ).trim();
                        document.getElementById('hotel_arrival').value = (
                            data.hotel_arrival || ''
                        ).trim();
                        document.getElementById('hotel_name').value = (
                            data.hotel_name || ''
                        ).trim();
                        document.getElementById(
                            'registration_desk_arrival'
                        ).value = (data.registration_desk_arrival || '').trim();
                        document.getElementById('payment_reference').value = (
                            data.payment_reference || ''
                        ).trim();
                        document.getElementById('payment_date').value = (
                            data.payment_date || ''
                        ).trim();
                        document.getElementById('wil_site_visit').value = (
                            data.wil_site_visit || ''
                        ).trim();
                        document.getElementById(
                            'delegate_official_address'
                        ).value = (data.delegate_official_address || '').trim();
                        document.getElementById(
                            'do_you_have_payment_proof'
                        ).value = (data.do_you_have_payment_proof || '').trim();
                        document.getElementById(
                            'plenary_Breakaway_session'
                        ).value = (data.plenary_Breakaway_session || '').trim();

                        document.getElementById('other_payment_proof').value = (
                            data.plenary_Breakaway_session || ''
                        ).trim();
                        document.getElementById('other_accommodation').value = (
                            data.plenary_Breakaway_session || ''
                        ).trim();
                        document.getElementById('other_hotel').value = (
                            data.plenary_Breakaway_session || ''
                        ).trim();
                        document.getElementById('other_title').value = (
                            data.plenary_Breakaway_session || ''
                        ).trim();

                        document.getElementById('position').value = (
                            data.position  || ''
                        ).trim();
                        document.getElementById('diet').value = (
                            data.diet  || ''
                        ).trim();

                         // Handle tittle logic
                        const validTitles = ['Ms', 'Mrs', 'Adv', 'Prof', 'Mr','Dr'];
                        const title = (data.title || '').trim();
                        if (!validTitles.includes(title)) {
                            document.getElementById('other_title').value =
                                title; // Set current title to other_title
                            document.getElementById('title').value = 'Other'; // Set title to 'Other'
                            document.getElementById('otherTitleField').style.display = "block";
                        } else {
                            document.getElementById('otherTitleField').style.display  = "none";
                            document.getElementById('other_title').value = ''; // Clear other_title if title is valid
                        }

                         // Handle hotel name logic
                        const validHotels = [
                            'Reserved Directly with Hotel',
                            'Booked Through your Travel Agent',
                            'Booked & Paid for through SASCE (2-night allocation 2nd & 3rd)',
                            'Accommodation not Booked/not needed'
                        ];
                        const hotelName = (data.hotel_name || '').trim();
                        if (!validHotels.includes(hotelName)) {
                            document.getElementById('other_hotel').value =
                                hotelName; // Set current hotel_name to other_hotel
                           // document.getElementById('hotel_name').value =
                              //  'Other'; // Set hotel_name to 'Other'
                               // document.getElementById('otherHotelField').style.display = "block";
                        } else {
                            document.getElementById('otherHotelField').style.display  = "none";
                            document.getElementById('other_hotel').value = ''; // Clear other_hotel if hotel_name is valid
                        }

                        // Handle accommodation logic
                        const validAccommodations = [
                            'Reserved Directly with Hotel',
                            'Booked Through your Travel Agent',
                        ];
                        const accommodation = (data.accommodation || '').trim();
                        if (!validAccommodations.includes(accommodation)) {
                            document.getElementById(
                                'other_accommodation'
                            ).value = accommodation; // Set current accommodation to other_accommodation
                            document.getElementById('accommodation').value =
                                'Other'; // Set accommodation to 'Other'
                                document.getElementById('otherAccommodationField').style.display = "block";
                        } else {
                            document.getElementById('otherAccommodationField').style.display  = "none";
                            document.getElementById(
                                'other_accommodation'
                            ).value = ''; // Clear other_accommodation if accommodation is valid
                        
                        }


                        ////payment proof 
                        const paymentProof = (
                            data.do_you_have_payment_proof || ''
                        ).trim();
                        if (paymentProof !== 'Yes' && paymentProof !== 'No') {
                            document.getElementById(
                                'other_payment_proof'
                            ).value = paymentProof; // Set current payment proof to other_payment_proof
                            document.getElementById(
                                'do_you_have_payment_proof'
                            ).value = 'Other'; // Set do_you_have_payment_proof to 'Other'
                            document.getElementById('otherPaymentField').style.display  = "block";

                        } else {
                            document.getElementById('otherPaymentField').style.display  = "none";
                            document.getElementById(
                                'other_payment_proof'
                            ).value = ''; // Clear other_payment_proof if payment proof is valid
                        }



                        // Handle registration desk arrival logic
                    const validRegistrationTimes = [
                        'Oct 2nd 8:00 AM - 8:00 PM at CCC',
                        'Oct 1st 2024 3:00 PM - 9:00 PM at the Conference Venue',
                        // Add other valid times here
                    ];
                    const registrationDeskArrival = (data.registration_desk_arrival || '').trim();
                    if (!validRegistrationTimes.includes(registrationDeskArrival)) {
                        document.getElementById('otherRegistrationField').style.display  = "block";
                        document.getElementById('other_registration_time').value = registrationDeskArrival; // Set current registration_desk_arrival to other_registration_time
                        document.getElementById('registration_desk_arrival').value = 'Other'; // Set registration_desk_arrival to 'Other'
                    } else {
                        document.getElementById('otherRegistrationField').style.display  = "none";
                        document.getElementById('other_registration_time').value = ''; // Clear other_registration_time if registration_desk_arrival is valid
                    }


                    document.getElementById('submission_type').value = 'update';

                        // Show or hide the abstract fields based on existing data
                        // const abstractValue = data.abstract || 'No';
                        //   document.getElementById('abstract').value = abstractValue;
                        // document.getElementById('abstractFields').style.display = abstractValue === 'Yes' ? 'block' : 'none';

                        // Change button text to "Update"
                        submitButton.innerText = 'Update';
                    } else {
                        // If email does not exist, don't clear the form and allow user to continue
                        submitButton.innerText = 'Submit';
                        document.getElementById('submission_type').value = 'submit';
                    }
                })
                .catch((error) => console.error('Error:', error));
        }
    }

    // Add event listener to check email on input change
    emailInput.addEventListener('input', checkEmail);

    // Handle abstract selection to show or hide fields
    //document.getElementById('abstract').addEventListener('change', function() {
    //     const abstractFields = document.getElementById('abstractFields');
    //     abstractFields.style.display = this.value === 'Yes' ? 'block' : 'none';
    // });
});
