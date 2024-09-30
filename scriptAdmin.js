let currentPage = 1;
const rowsPerPage = 1000;
let submissions = []; // This should be fetched from the server

// Function to load data
function loadData() {
    fetch('ViewApi.php?page=1&search=')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
        
            console.log(data);  // Check what data is being returned
            submissions = data.data || [];  // Assign data to submissions or an empty array
            displayTable();  // Display table data
            document.getElementById('totalCount').textContent = data.totalCount || 0;  // Display total count
        })
        .catch(error => console.error('Error fetching data:', error));
}


// Function to display the table
function displayTable() {
    const tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';

    if (!Array.isArray(submissions)) {
        console.error('Submissions is not an array:', submissions);
        return;
    }

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedItems = submissions.slice(start, end);
let num = 1;
    paginatedItems.forEach(submission => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${num++}</td>
            <td>${submission.title}</td>
            <td>${submission.name}</td>
            <td><a href="#" class="email-link">${submission.email}</a></td>
            <td>${submission.phone}</td>
            <td>${submission.institution}</td>
            <td>${submission.position}</td>
            <td>${submission.Timestamp}</td>
            <td>${submission.created_at}</td>
            
        `;
 // Attach click event to the email link
 row.querySelector('.email-link').addEventListener('click', function(event) {
    event.preventDefault();  // Prevent default link behavior
    showModal(submission);   // Show the modal with submission data
});

        tableBody.appendChild(row);
    });
}

// Function to search the table
function searchTable() {
    const searchTerm = document.getElementById('search').value.toLowerCase();
    const filteredSubmissions = submissions.filter(submission =>
        submission.name.toLowerCase().includes(searchTerm) ||
        submission.email.toLowerCase().includes(searchTerm)
    );
    displayFilteredTable(filteredSubmissions);
}

// Function to display the filtered table
function displayFilteredTable(data) {
    let num = 1;
    const tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedItems = data.slice(start, end);

    paginatedItems.forEach(submission => {
        const row = document.createElement('tr');
        row.innerHTML = `
             <td>${num++}</td>
            <td>${submission.title}</td>
            <td>${submission.name}</td>
           <td><a href="#" class="email-link">${submission.email}</a></td>
            <td>${submission.phone}</td>
            <td>${submission.institution}</td>
            <td>${submission.position}</td>
            <td>${submission.Timestamp}</td>
            <td>${submission.created_at}</td>
            
        
        `;

        row.addEventListener('click', () => showModal(submission));
        tableBody.appendChild(row);
    });
}

// Function to handle pagination
// function changePage(direction) {
//     const newPage = currentPage + direction;
//     if (newPage > 0 && newPage <= Math.ceil(submissions.length / rowsPerPage)) {
//         currentPage = newPage;
//         displayTable();
//     }
// }


document.getElementById('downloadUsersBtn').addEventListener('click', function() {
    // Fetch the data from the API
    fetch('ViewApi.php')
        .then(response => response.json())
        .then(data => {
           // Define headers for the Excel file
const headers = [
    'Timestamp',
    'Email Address',
    'Your Title',
    'Name and SURNAME',
    'Your primary cellphone contact number for duration of the Conference',
    'institution',
    'Your Designation/Position',
    '2024 SASCE Membership Type',
    'Will you be attending ONLY as... An EXHIBITOR? Exhibition Fee is R16500 per stand, Platinum Member discount will apply',
    'Will you be attending the Research Publishing Workshop from 9h30, 2nd Oct by the Editor of IJWIL? If yes, NB: Seats are limited, allocated on First-Paid-First Served and First-Come-First-Served basis (Registration at CPUT Hotel School, Granger Bay 9h00-9h30)',
    'Will you be presenting an abstract? IF YES, Pls NOTIFY or register for your poster allocation/location via email: fishera@cput.ac.za; overmeyerp@cput.ac.za and cc events@sasce.net',
    'If submitting an abstract: Sub-theme under which your Paper/Abstract falls',
    'If your abstract is NOT covered by the subthemes above, please provide Motivation for the Topic, in WIL Context',
    'Topic of your Paper/Abstract',
    'Upload your Presentation (If can\'t upload Audio/Large file, kindly liaise through: fishera@cput.ac.za; overmeyerp@cput.ac.za)',
    //'If part of a GROUP on same Cost Centre please request GROUP invoice : Click on the link and download a copy of the form to fill in information relating to all delegates to be included on the invoice. WIL Africa 2024 Request for invoice form.doc',
    'Are you personally responsible for payment, or you are part of a group/the Institution is responsible?',
    'If YOU are not personally responsible for payment, who should be contacted to invoice you and other delegates from your organisation; Please supply their email address and tel. number',
    'Official Address',
    'Office Telephone Number',
    'Will you attend West Coast 4IR CoE WIL site visit?',
    'Estimated Time of Arrival at your hotel',
    'Name of the Hotel YOU are Booked in NB: IF your arrival is BEFORE 2nd October, kindly make sure you have made appropriate arrangement for the additional night AND Paid directly WITH your HOTEL',
    'Estimated time of Arrival at Conference Registration Desk',
    'How was YOUR hotel accommodation made?',
    'Do you HAVE YOUR payment confirmation from your Procurement/Finance department?',
    'Verification - Conference Payment Reference no. details',
    'Conference Payment Date (reflected from your Finance admin)',
    'Please UPLOAD your Proof of Payment referenced above, if can\'t upload, pls your YOUR PoP to: matseke@sasce.net',
    'Will you be presenting at a Plenary/Breakaway Session?',
    'Please state special dietary requirements if any',
    'Upload your Filled-in form',
    'Upload Request for Invoice for Registration (With Individuals\' FULL details for each delegate to be billed to your cost centre)',
    "Timestamp new form"
];

// Initialize rows for the Excel file with headers
const rows = [headers];

// Loop through the data and push each row to rows array
data.data.forEach(submission => {
    rows.push([
        submission.Timestamp,
        submission.email,
        submission.title,
        submission.name,
        submission.phone,
        submission.institution,
        submission.position,
        submission.membership_type,
        submission.exhibitor,
        submission.workshop,
        submission.abstract,
        submission.subtheme,
        submission.motivation,
        submission.topic,
        submission.upload_your_Abstract,
        submission.responsible_payment,
        submission.invoice_contact,
        submission.delegate_official_address,
        submission.office_number,
        submission.wil_site_visit,
        submission.hotel_arrival,
        submission.hotel_name,
        submission.registration_desk_arrival,
        submission.accommodation,
        submission.do_you_have_payment_proof,
        submission.payment_reference,
        submission.payment_date,
        submission.upload_pop,
        submission.plenary_Breakaway_session,
        submission.diet,
        submission.upload_filled_in_form,
        submission.upload_request_invoice,
        submission.created_at
    ]);
});


            // Create a new Workbook
            const wb = XLSX.utils.book_new();

            // Convert data to worksheet
            const ws = XLSX.utils.aoa_to_sheet(rows);

            // Append the worksheet to the workbook
            XLSX.utils.book_append_sheet(wb, ws, "Submissions");

            // Generate Excel file and trigger download
            XLSX.writeFile(wb, "submissions_data.xlsx");
        })
        .catch(error => console.error('Error fetching data:', error));
});

function showModal(submission) {
    // Populate modal with submission data
    document.getElementById('modalTimestamp').textContent = submission.Timestamp || 'N/A';
    document.getElementById('modalEmail').textContent = submission.email || 'N/A';
    document.getElementById('modalName').textContent = submission.name || 'N/A';
    document.getElementById('modalPhone').textContent = submission.phone || 'N/A';
    document.getElementById('modalInstitution').textContent = submission.institution || 'N/A';
    document.getElementById('modalPosition').textContent = submission.position || 'N/A';
    document.getElementById('modalMembership').textContent = submission.membership_type || 'N/A';
    document.getElementById('modalExhibitor').textContent = submission.exhibitor || 'N/A';
    document.getElementById('modalWorkshop').textContent = submission.workshop || 'N/A';
    document.getElementById('modalAbstract').textContent = submission.abstract || 'N/A';
    document.getElementById('modalSubtheme').textContent = submission.subtheme || 'N/A';
    document.getElementById('modalMotivation').textContent = submission.motivation || 'N/A';
    document.getElementById('modalTopic').textContent = submission.topic || 'N/A';
    document.getElementById('modalUploadedAbstract').textContent = submission.upload_your_abstract || 'N/A';
    document.getElementById('modalUploadInvoice').textContent = submission.upload_invoice || 'N/A';
    document.getElementById('modalResponsiblePayment').textContent = submission.responsible_payment || 'N/A';
    document.getElementById('modalInvoiceContact').textContent = submission.invoice_contact || 'N/A';
    document.getElementById('modalDelegateAddress').textContent = submission.delegate_official_address || 'N/A';
    document.getElementById('modalOfficeNumber').textContent = submission.office_number || 'N/A';
    document.getElementById('modalWilSiteVisit').textContent = submission.wil_site_visit || 'N/A';
    document.getElementById('modalArrivalTimeHotel').textContent = submission. hotel_arrival || 'N/A';
    document.getElementById('modalHotelName').textContent = submission.hotel_name || 'N/A';
    document.getElementById('modalArrivalTimeRegistration').textContent = submission.registration_desk_arrival || 'N/A';
    document.getElementById('modalAccommodationMade').textContent = submission.accommodation || 'N/A';
    document.getElementById('modalPaymentProof').textContent = submission.upload_pop || 'N/A';
    document.getElementById('modalPaymentReference').textContent = submission.payment_reference || 'N/A';
    document.getElementById('modalPaymentDate').textContent = submission.payment_date || 'N/A';
    document.getElementById('modalUploadPOP').textContent = submission.upload_pop || 'N/A';
    document.getElementById('modalCreatedAt').textContent = submission.created_at || 'N/A';
    document.getElementById('modalUpdatedAt').textContent = submission.updated_at || 'N/A';
    document.getElementById('modalRequestInvoice').textContent = submission.upload_request_invoice || 'N/A';
    document.getElementById('modalFillInForm').textContent = submission.modalFillInForm || 'N/A';
    document.getElementById('modalDiet').textContent = submission.diet || 'N/A';
    // Display the modal
    document.getElementById('userModal').style.display = 'block';
}

// Close the modal
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('userModal').style.display = 'none';
});

// Also close the modal if the user clicks outside of the modal content
window.addEventListener('click', function(event) {
    const modal = document.getElementById('userModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Load data on page load
document.addEventListener('DOMContentLoaded', loadData);
