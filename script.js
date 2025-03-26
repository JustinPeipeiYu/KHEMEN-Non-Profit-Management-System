/*
© 2025 Khemen Script.
*/
function showDonateNowModal() {
    document.getElementById("donateNowModal").style.display = "block";
}
function hideDonateNowModal() {
    document.getElementById("donateNowModal").style.display = "none";
}
function showDonateNowClose() {
    document.getElementById("donateNowClose").style.display = "block";
}
function hideDonateNowClose() {
    document.getElementById("donateNowClose").style.display = "none";
}
function showLoginModal() {
    document.getElementById("loginModal").style.display = "block";
}
function hideLoginModal() {
    document.getElementById("loginModal").style.display = "none";
}
function showLoginClose() {
    document.getElementById("loginClose").style.display = "block";
}
function hideLoginClose() {
    document.getElementById("loginClose").style.display = "none";
}
/*
window.onclick = function(event) {
    var donateModal = document.getElementById("donateModal");
    var subscriptionModal = document.getElementById("subscriptionModal");
    if (event.target == donateModal) {
        donateModal.style.display = "none";
    }
    if (event.target == subscriptionModal) {
        subscriptionModal.style.display = "none";
    }
}
*/
function updatePost(section) {
    var title = document.querySelector("#page .post .title");
    var entry = document.querySelector("#page .post .entry");
    var menu = document.querySelector("#wrapper #header-wrapper #header #menu ul");
    //clear css on selected tab from navigation bar
    menu.getElementsByClassName("current_page_item")[0].classList.remove("current_page_item");
    //menu.querySelector(".current_page_item").classList.remove("current_page_item");
    switch (section) {//apply css to the new selected tab //set the page title //set page description
        case "about":
            menu.querySelector("#about_tab").classList.add("current_page_item");
            heading = "<h2> About Us </h2>";
            message = "<p>Khemen is a non-profit organization dedicated to making a difference in communities by providing resources, support, and opportunities to those in need.</p><p>Our mission is to empower individuals and organizations through sustainable initiatives and community-driven projects.</p>";
            break;
        case "contact":
            menu.querySelector("#contact_tab").classList.add("current_page_item");
            heading = "<h2> Contact Us </h2>";
            message = "<p>We'd love to hear from you! Reach out to us with any questions, partnership opportunities, or ways to get involved.</p><p><strong>Email:</strong> info@khemen.org</p><p><strong>Phone:</strong> (123) 456-7890</p><p><strong>Address:</strong> 123 Charity Lane, Community City, CC 56789</p>";
            break;
        case "donate":
            menu.querySelector("#donate_tab").classList.add("current_page_item");
            heading = "<h2> Donate </h2>";
            message = "<p>Your support makes our mission possible. Every donation helps us provide aid, resources, and opportunities to those in need.</p><p>Thank you for your generosity and commitment to making a difference.</p>";
            break;
        case "involved":
            menu.querySelector("#involve_tab").classList.add("current_page_item");
            heading = "<h2> Get Involved </h2>";
            message = "<p>You can help make a difference by supporting Khemen in various ways.</p><p>Volunteer, partner with us, or spread awareness to contribute to our mission of helping communities in need.</p>";
            break;
        case "work":
            menu.querySelector("#work_tab").classList.add("current_page_item");
            heading = "<h2> Our Work </h2>";
            message = "<p>At Khemen, we focus on impactful projects that drive positive change in communities.</p><p>Our initiatives include education support, food assistance, and community-building programs aimed at fostering a brighter future.</p>";
            break;
        default:
            menu.querySelector("#home_tab").classList.add("current_page_item");
            heading = "<h2> Welcome to Khemen </h2>";
            message = "<p><strong>Khemen</strong> is a non-profit organization dedicated to supporting communities throughcharitable donations and impactful programs. Our mission is to make giving simple, transparent,and meaningful.</p><p>We believe in the power of collective action to create lasting change. Whether through directcontributions or volunteering, every effort helps us build stronger communities.</p>";
    }
    title.innerHTML = heading;
    entry.innerHTML = message;
}

function validateForm() {
    // Validate phone number
    var phoneNumber = document.getElementById("phone").value;
    var phonePattern = /^\+1\s\d{3}\s\d{3}\s\d{4}$/;
    if (!phonePattern.test(phoneNumber)) {
        alert("Please enter a valid Canadian phone number in the format +1 xxx xxx xxxx.");
        return false;
    }

    // Validate card number (16 digits)
    var cardNumber = document.getElementById("cardnumber").value;
    var cardPattern = /^\d{16}$/;
    if (!cardPattern.test(cardNumber)) {
        alert("Please enter a valid 16-digit card number.");
        return false;
    }

    // Validate expiration date (MM/YY format)
    var expiry = document.getElementById("expiry").value;
    var expiryPattern = /^(0[1-9]|1[0-2])\/\d{2}$/;
    if (!expiryPattern.test(expiry)) {
        alert("Please enter a valid expiration date in MM/YY format.");
        return false;
    }

    // Validate CVV (3-4 digits)
    var cvv = document.getElementById("cvv").value;
    var cvvPattern = /^\d{3,4}$/;
    if (!cvvPattern.test(cvv)) {
        alert("Please enter a valid CVV (3 or 4 digits).");
        return false;
    }

    // Validate amount (must be greater than 0)
    var amount = document.getElementById("amount").value;
    if (isNaN(amount) || amount <= 0) {
        alert("Please enter a valid amount greater than 0.");
        return false;
    }

    return true;
}