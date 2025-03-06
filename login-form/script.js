document.querySelector('.clickableText a:nth-child(2)').addEventListener("click", function(event) { 
    event.preventDefault(); // Prevents the link from navigating
    switch (event.target.id) {//toggles the position of text when link is clicked 
        case 'signup':
            document.getElementById('Title').innerText = 'Sign Up';
            event.target.innerText = 'Sign in';
            event.target.setAttribute('id','signin');
            break;
        default:
            document.getElementById('Title').innerText = 'Sign In';
            event.target.innerText = 'Sign up';
            event.target.setAttribute('id','signup');
    };
 });
 