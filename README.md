# bnb-IT537

Assignment in IT - Web Development

To create a website and publish it...

Website can be viewed at http://ongaongabnb.unaux.com/

Home Page if for the index.php {welcomes the user/customer to the page}
Rooms show all the available rooms achieved by importing from database in room table shows basic info as per view function (room name, roomtype, description and bed)
Booking Page serves as Create Booking, also includes a search available room at the bottom using AJAX
Register is basically the Create Customer page. Note: Passwords are hashed when sent to server for added security
Login is logging in to the website to access booking and other pages. Do note that admin can view Admin Page while non-admin is unable to see it. Password uses password_verify to access hashed passwords
Admin Page is where the Customer List, Room List and Current Booking List are. Here you can to admin stuff, create, edit and delete information.
