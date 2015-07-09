<?php

require("./app/core/SectionBuilder.php");
require("./app/core/NavigationBuilder.php");

$renderer   = new SectionBuilder();
$navigation = new NavigationBuilder();

?>

<section class="getRequests" id="get">
    <section class="wrapper">
        <h2>GET Requests</h2>
        <?php
        $navigation->addItem("GET Requests", "get", true);
        // GET User
        $renderer->renderHeader(
            "getUser",
            "Retrieve a specific User",
            "Based on a users ID, this method will query the database for that specific user and return a JSON object with all of their values.",
            "GET",
            "User/{userId}",
            "This endpoint should be used to return a specific users profile"
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The ID of the user that needs to be retrieved."
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The user was retrieved successfully, this is accompanied by a user payload",
                "401" => "Your session_token and/or device_id combination was not found in the DB. Login again",
                "404" => "The user was not found on the server"
            )
        );
        $renderer->renderTestResponse(
            Array(
                    "Content-Type: application/json",
                    "session_token: adminToken",
                    "device_id: adminDevice"
            ),
            Array(),
            REQUEST_URL . "User/386",
            "GET"
        );
        $navigation->addItem("Retrieve a specific User", "getUser");
        // GET Users at location (for list view)
        $renderer->renderHeader(
            "getUsersAtLocation",
            "Retrieve all Users",
            "Returns all users that match the logged in users preferences and settings, this is impacted by age range, gender and other factors.  Right now this method will return every user in the system that matches the preferences, but as the application gets more users a max radius filter will be implemented, with that in mind the URI parameters now make more sense.",
            "GET",
            "User/at-location/long/lat/{limit}",
            "This endpoint should be used to return all users for the list view, do not use this for the map view."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "long" => "The current longitude of the user",
                "lat"  => "The current latitude of the user",
                "limit*" => "The limit to the amount of users that should be returned, this key is optional"
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "Returns a list of all of the users who are within a certain distance of your location.",
                "401" => "Your session_token and/or device_id combination was not found in the DB. Login again",
                "404" => "No users were found for the given user, users may appear if settings and preferences are changed."
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(),
            REQUEST_URL . "User/at-location/0.0002324/-0.013243/2",
            "GET"
        );
        $navigation->addItem("Retrieve all Users", "getUsersAtLocation");
        // GET Favorite Places
        $renderer->renderHeader(
            "getFavoritePlaces",
            "Retrieve a Users Favorite Places",
            "Returns list of the favorite places for the requested user, this information is returned in the <mark>/api/v2/User/{userId}</mark> endpoint, but this provides an interface to return them if you desire them as a separate object.",
            "GET",
            "User/favorite-places/{userId}",
            "This endpoint should be used to return all of a users favorite places."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The id of the user that the favorite places should be returned for."
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "Returns a list of all of a users favorite places",
                "401" => "Your session_token and/or device_id combination was not found in the DB. Login again",
                "404" => "No favorite places were returned for this user."
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(),
            REQUEST_URL . "User/favorite-places/386",
            "GET"
        );
        $navigation->addItem("Retrieve a Users Favorite Places", "getFavoritePlaces");
        // GET Preferences
        $renderer->renderHeader(
            "getPreferences",
            "Retrieve a Users Preferences",
            "Retrieves a list of a users preferences. Please note that preferences are returned in the login payload, so it would be better practice to add them to a User singleton on login rather than querying this method.",
            "GET",
            "User/preferences/{userId}",
            "This endpoint should be used to return all of a users preferences, preferences are different to settings in that they determine the preferred age range, the checkin expiry and the types of friends they want to see."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The id of the user that the preferences should be returned for."
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "Returns a list of all of a users preferences",
                "401" => "Your session_token and/or device_id combination was not found in the DB. Login again",
                "409" => "No preferences were returned, this user must be invalid, try and send a new entity id"
            )
        );
        $renderer->renderOutputInfo(
           Array(
               "Pref_Chk_Exp"   => "The expiry of any checkins posted by this user in hours, either 1, 4 or 8",
               "Pref_Facebook"  => "Either 1 or 0, determines if the person wants to see Facebook friends",
               "Pref_Kinekt"    => "Either 1 or 0, determines if the person wants to see Kinekt friends",
               "Pref_Everyone"  => "Either 1 or 0, determines if the person wants to see Everyone, this will override Pref_Kinekt and Pref_Facebook",
               "Pref_Sex"       => "Determines which genders the user wants to view, 1 = Male, 2 = Female, 3 = Both",
               "Pref_Lower_Age" => "Determines the lowest age boundary to show to the user, ages < 18 will default to 18.",
               "Pref_Upper_Age" => "Determines the upper age boundary to show to the user, ages > 50 will default to 150 in a query, this is to bypass any erroneous Facebook ages."
           )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(),
            REQUEST_URL . "User/preferences/386",
            "GET"
        );
        $navigation->addItem("Retrieve a Users Preferences", "getPreferences");
        // GET Settings
        $renderer->renderHeader(
            "getSettings",
            "Retrieve a Users Settings",
            "Retrieves a list of a users settings. Please note that settings are returned in the login payload, so it would be better practice to add them to a User singleton on login rather than querying this method.",
            "GET",
            "User/settings/{userId}",
            "This endpoint should be used to return all of a users settings, settings are different to settings in that they determine type of push notifications that they will receive."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The id of the user that the settings should be returned for."
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "Returns a list of all of a users settings",
                "401" => "Your session_token and/or device_id combination was not found in the DB. Login again",
                "409" => "No settings were returned, this user must be invalid, try and send a new entity id"
            )
        );
        $renderer->renderOutputInfo(
            Array(
                "Pri_Checkin"            => "Determines who can view checkins, 1 = friends, 2 = everybody",
                "Pri_Visability"         => "Determines who can view the user on the map, 1 = 500km radius, 2 = country wide, 3 = worldwide ",
                "Notif_Tag"              => "Determines whether or not to receive notifications for tags, 1 = yes, 0 = no",
                "Notif_Msg"              => "Determines whether or not to receive notifications for messages, 1 = yes, 0 = no",
                "Notif_New_Friend"       => "Determines whether or not to receive notifications for accepted or rejected friend requests, 1 = yes, 0 = no",
                "Notif_Friend_Request"   => "Determines whether or not to receive notifications for new friend requests, 1 = yes, 0 = no",
                "Notif_Checkin_Activity" => "Determines whether or not to receive notifications for comments or likes on checkins, 1 = yes, 0 = no",
                "list_visibility"        => "Determines who can view the user on the list view, 1 = everybody, 2 = friends, 3 = hidden"
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(),
            REQUEST_URL . "User/settings/386",
            "GET"
        );
        $navigation->addItem("Retrieve a Users Settings", "getSettings");
        // GET Notifications
        $renderer->renderHeader(
            "getNotifications",
            "Retrieve a Users Notifications",
            "Returns a list of all current notifications for this user.  The database runs a batch script to delete notifications which are more than 3 days old so this will only ever show the most recent notifications.",
            "GET",
            "User/notifications/{userId}",
            "This endpoint should be used to return all of a users notifications"
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The id of the user that the favorite places should be returned for."
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "Returns a list of all of a users notifications",
                "401" => "Your session_token and/or device_id combination was not found in the DB. Login again",
                "404" => "This user has no notifications"
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(),
            REQUEST_URL . "User/notifications/386",
            "GET"
        );
        $navigation->addItem("Retrieve a Users Notifications", "getNotifications");


        ?>
    </section>
</section>

<section class="putRequests" id="put">
    <section class="wrapper">
        <h2>PUT Requests</h2>
        <?php
        $navigation->addItem("PUT Requests", "put", true);
        // Update Location
        $renderer->renderHeader(
            "updateLocation",
            "Update a Users Location",
            "Updates the users location based on the current longitude and latitude.",
            "PUT",
            "User/location/lat/long",
            "This endpoint should be used to update the users location when they sign in to the app on a new session, this ensures that every user of the app has some long/lat information in the database. This used to be an important requirement in the iOS v1.0 app as having long/lat information in the user payload would break the map, it may not be so important to use now."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "lat"  => "The current latitude of the user",
                "long" => "The current longitude of the user"
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "Returns a list of all of the users who are within a certain distance of your location.",
                "401" => "Your session_token and/or device_id combination was not found in the DB. Login again",
                "404" => "No users were found for the given user, users may appear if settings and preferences are changed."
            )
        );
        $navigation->addItem("Update a Users Location", "updateLocation");
        // Update Profile
        $renderer->renderHeader(
            "updateProfile",
            "Update a Users Profile Information",
            "Given an input payload, this method will update the users profile information. Any number of keys can be sent as the query will be generated based on the input keys, a dob key must however be supplied to validate the users age.  Valid keys can be found below in the input parameter description.",
            "PUT",
            "User/update-profile/{userId}",
            "This endpoint should be used to update the users profile information, the underlying method is called on signin to set the latest profile picture from the Facebook API, as well as any bio information ported from Facebook."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The user id of the signed in user, if you provide a user id that does not match the one returned from the session, a 401 will be returned.  This is because you should not be able to update other peoples profiles."
            )
        );
        $renderer->renderInputParameters(
            Array(
                "first_name" => "The new first name for the user",
                "last_name"  => "The new last name for the user",
                "profile_pic_url" => "The new profile pic url for the user, this is derived from image urls returned from the FB API.",
                "entity_id" => "The entity id in the database of the user",
                "fb_id [DEPRECATED]" => "The facebook id of the user, this shouldn't be updated. Instead a new account should be made",
                "email" => "The users new email address",
                "dob [REQUIRED]" => "The date of birth, used to validate the request. Format mask of yyyy/mm/dd",
                "sex" => "1 for male, 2 for female",
                "about" => "The new about information for the user",
                "image_urls" => "Sets the new image urls that the FB API returns."
        )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The user is already up to date, and therefore the transaction did not complete",
                "203" => "The user was updated successfully",
                "400" => "You must be 18 or older to use this app",
                "401" => "The entity id you attempted to update does not match the entity id associated with the session.",
                "404" => "The user was not found, caused by using an invalid entity id."
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(
                "First_Name" => "Davies",
                "dob" => "11/14/1992"
            ),
            REQUEST_URL . "User/update-profile/367",
            "PUT"
        );
        $navigation->addItem("Update a Users Profile Info", "updateProfile");
        // Update Settings
        $renderer->renderHeader(
            "updateSettings",
            "Update a Users Settings",
            "Given an input payload, this method will update the users settings. Any number of keys can be sent as the query will be generated based on the input keys. Valid keys can be found below in the input parameter description.",
            "PUT",
            "User/update-settings/{userId}",
            "This endpoint should be used to update the users settings to tailor system behaviour toward their needs."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The user id of the signed in user, if you provide a user id that does not match the one returned from the session, a 401 will be returned.  This is because you should not be able to update other peoples profiles."
            )
        );
        $renderer->renderInputParameters(
            Array(
                "privacyCheckin"        => "Determines who can view checkins, 1 = friends, 2 = everybody",
                "privacyVisibility"     => "Determines who can view the user on the map, 1 = 500km radius, 2 = country wide, 3 = worldwide ",
                "notifTag"              => "Determines whether or not to receive notifications for tags, 1 = yes, 0 = no",
                "notifMessages"         => "Determines whether or not to receive notifications for messages, 1 = yes, 0 = no",
                "notifNewFriends"       => "Determines whether or not to receive notifications for accepted or rejected friend requests, 1 = yes, 0 = no",
                "notifFriendRequests"   => "Determines whether or not to receive notifications for new friend requests, 1 = yes, 0 = no",
                "notifCheckinActivity"  => "Determines whether or not to receive notifications for comments or likes on checkins, 1 = yes, 0 = no",
                "listVisibility"        => "Determines who can view the user on the list view, 1 = everybody, 2 = friends, 3 = hidden"
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The user was updated successfully",
                "203" => "The settings are already up to date, and therefore the transaction did not complete",
                "400" => "The update failed because no valid tags were provided in the input payload",
                "401" => "The entity id you attempted to update does not match the entity id associated with the session.",
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(
                "listVisibility" => 1
            ),
            REQUEST_URL . "User/update-settings/367",
            "PUT"
        );
        $navigation->addItem("Update a Users Settings", "updateSettings");
        // Update Preferences
        $renderer->renderHeader(
            "updatePreferences",
            "Update a Users Preferences",
            "Given an input payload, this method will update the users preferences. Any number of keys can be sent as the query will be generated based on the input keys. Valid keys can be found below in the input parameter description.",
            "PUT",
            "User/update-preferences/{userId}",
            "This endpoint should be used to update the users preferences to tailor system behaviour toward their needs."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The user id of the signed in user, if you provide a user id that does not match the one returned from the session, a 401 will be returned.  This is because you should not be able to update other peoples profiles."
            )
        );
        $renderer->renderInputParameters(
            Array(
                "Pref_Chk_Exp"   => "The expiry of any checkins posted by this user in hours, either 1, 4 or 8",
                "Pref_Facebook"  => "Either 1 or 0, determines if the person wants to see Facebook friends",
                "Pref_Kinekt"    => "Either 1 or 0, determines if the person wants to see Kinekt friends",
                "Pref_Everyone"  => "Either 1 or 0, determines if the person wants to see Everyone, this will override Pref_Kinekt and Pref_Facebook",
                "Pref_Sex"       => "Determines which genders the user wants to view, 1 = Male, 2 = Female, 3 = Both",
                "Pref_Lower_Age" => "Determines the lowest age boundary to show to the user, ages < 18 will default to 18.",
                "Pref_Upper_Age" => "Determines the upper age boundary to show to the user, ages > 50 will default to 150 in a query, this is to bypass any erroneous Facebook ages."
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The preferences were updated successfully",
                "203" => "The preferences are already up to date, and therefore the transaction did not complete",
                "400" => "The update failed because no valid tags were provided in the input payload",
                "401" => "The entity id you attempted to update does not match the entity id associated with the session.",
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(
                "Pref_Chk_Exp" => 1
            ),
            REQUEST_URL . "User/update-preferences/367",
            "PUT"
        );
        $navigation->addItem("Update a Users Preferences", "updatePreferences");
        // Update Score
        $renderer->renderHeader(
            "updateScore",
            "Update a Users Score",
            "This method will add a specified amount of points to a users score.  This is generally called internally, but can be utilised directly from the app if you need to do so.",
            "PUT",
            "User/update-score/{scoreAmount}",
            "This endpoint should be used to update a users score only when necessary, most methods that reward score will call this method internally."
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "scoreAmount" => "The amount of points to be added to the session holders current score."
            )
        );
        $renderer->renderInputParameters(
            Array(

            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The score was updated successfully",
                "400" => "An uncaught error occured when updating the score",
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array("entityId"=>"367"),
            REQUEST_URL . "User/update-score/10",
            "PUT"
        );
        $navigation->addItem("Update a Users Score", "updateScore");
        ?>
    </section>
</section>

<section class="postRequests" id="post">
    <section class="wrapper">
        <h2>POST Requests</h2>
        <?php
        $navigation->addItem("POST Requests", "post", true);
        // Logging In
        $renderer->renderHeader(
            "loginUser",
            "Logging in and Signing Up",
            "This endpoint handles both the logging in and signing up of a user.  It is the only endpoint which does not require a session_token and device_id to be sent in the HTTP headers.",
            "POST",
            "User/login",
            "This endpoint to log in and sign up users. If no account exists, the system will automatically sign them up with the given payload, otherwise the user will be signed in.  All information on the user is returned on a successful login, including the new token for the session, this information is required for authorising all requests in the API."
        );
        $renderer->renderInputParameters(
            Array(
                "facebook_id" => "The facebook id for the user, this will never change",
                "first_name" => "The users first name, on each login this will update if the user changes it on facebook",
                "last_name" => "The users last name, same behaviour as first_name",
                "email" => "The users email, again this will change if changed on facebook",
                "profile_pic_url" => "The users current facebook profile picture, will change if changes on Facebook",
                "sex" => "The gender of the user, either 1 for male or 2 for female",
                "dob" => "The users date of birth in yyyy/mm/dd format, this will validate the users age",
                "about" => "The users bio, inherited from facebook, but can be set in the app in the users profile",
                "image_urls" => "An array of images from the facebook graph api",
                "device_id" => "The device that is being logged in from, Android and Apple have some API calls to retreive this info on the device.  If an account exists with the same device_id the session is updated, else a new session is created for that device.  This allows for multiple sessions for the same account, we can extend this later for security purposes to log people out from un-verified locations.",
                "friends" => "An array of facebook id's returned from the Facebook API call. This is used to add mutual friends to the app on each login",
                "device_type" => "The type of device, 1 is Apple and 2 is Android.  This is used to determine which push notification method to invoke when sending notifications."
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The user was created or retrieved successfully, see the output in the test response.",
                "400" => "No JSON payload was sent to the server, therefore the user cannot be logged in or created",
                "401" => "You must be older than 18 to register or sign in to the app",
                "500" => "There was an uncaught internal error when creating the user, try again."
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(
                "device_id"   => "some_device_id",
                "facebook_id" => "904323402922802",
                "first_name"  => "Davis",
                "last_name"   => "Allie",
                "email"       => "davis525@live.com.au",
                "profile_pic_url" => "https://fbcdn-sphotos-f-a.akamaihd.net/hphotos-ak-xfp1/v/t1.0-9/1921993_729583840396760_746137118034031653_n.jpg?oh=1b671969f1953df9ccfa7d8cb343bd91&oe=5631DD73&__gda__=1444219762_398e80c1b93f60c0096968c5a4697d7c",
                "sex" => "1",
                "dob" => "1992/11/14",
                "about" => "D",
                "friends" => "",
                "device_type" => "1",
                "image_urls" => "https://fbcdn-sphotos-h-a.akamaihd.net/hphotos-ak-xpa1/t31.0-8/s720x720/1276869_625922220762923_1589444375_o.jpg,https://scontent.xx.fbcdn.net/hphotos-xat1/t31.0-8/s720x720/1072432_601259323229213_23110517_o.jpg,https://fbcdn-sphotos-e-a.akamaihd.net/hphotos-ak-ash2/t31.0-8/1404530_646361452052333_88553249_o.jpg,https://scontent.xx.fbcdn.net/hphotos-xaf1/t31.0-8/323743_313496878672127_1823668690_o.jpg"
            ),
            REQUEST_URL . "User/login",
            "POST"
        );
        $navigation->addItem("Logging in and Signing Up", "loginUser");
        // Add Favorite
        $renderer->renderHeader(
            "addFavorite",
            "Add a Favourite Place",
            "This endpoint allows a user to add a new favorite place to their collection of favorite places.",
            "POST",
            "User/add-favourite/{userId}",
            "This endpoint to log in and sign up users. If no account exists, the system will automatically sign them up with the given payload, otherwise the user will be signed in.  All information on the user is returned on a successful login, including the new token for the session, this information is required for authorising all requests in the API."
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The ID of the user that is being logged in"
            )
        );
        $renderer->renderInputParameters(
            Array(
                "placeName" => "The name of the place you wish to add",
                "picUrl" => "A URL to an image to be associated with this place"
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The place was added to your favourites, a JSON payload detailing its information is returned here too.",
                "401" => "Your session_token and/or device_id combination was not found in the DB. Login again",
                "409" => "The favourite place you attempted to add already exists in your collection."
            )
        );
        $renderer->renderTestResponse(
            Array(
                "Content-Type: application/json",
                "session_token: adminToken",
                "device_id: adminDevice"
            ),
            Array(
                "placeName" => "Garys bar",
                "picUrl" => "some_url",

            ),
            REQUEST_URL . "User/add-favorite/386",
            "POST"
        );
        $navigation->addItem("Add a Favourite Place", "addFavorite");
        ?>
    </section>
</section>

<section class="deleteRequests" id="delete">
    <section class="wrapper">
        <h2>DELETE Requests</h2>
        <?php
        $navigation->addItem("DELETE Requests", "delete", true);
        // Remove User
        $renderer->renderHeader(
            "deleteAccount",
            "Delete a User Account",
            "This method will permanently delete the user from the system, there is no archive for deleted users so this change is immutable",
            "DELETE",
            "User/delete-account/{userId}",
            "This endpoint should be used to delete a users account, please build some front end validation to prompt the user of the immutable change"
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The id of the user who is to be deleted"
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The user was deleted successfully",
                "400" => "There was a problem with the query, the account was not deleted",
                "401" => "The entity id you attempted to update does not match the entity id associated with the session.",
            )
        );
        $navigation->addItem("Delete a User Account", "deleteAccount");
        // Sign Out
        $renderer->renderHeader(
            "deleteSession",
            "Sign a User Out",
            "This method is used to delete the current session on the current device, it does not log users out across all devices, however the method could be extended in future to provide this functionality.",
            "DELETE",
            "User/sign-out/{userId}",
            "This endpoints should be used to destroy the current session, once this occurs you should redirect them to the login page"
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "userId" => "The id of the user who is to be deleted"
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The user was signed out successfully",
                "400" => "There was a problem with the query, the user was not signed out, try again.",
                "401" => "The entity id you attempted to update does not match the entity id associated with the session."
            )
        );
        $navigation->addItem("Sign a User Out", "deleteSession");
        // Remove Favourite
        $renderer->renderHeader(
            "deleteFavourite",
            "Remove a Favourite Place",
            "This method removes a favourite places from the users collection.",
            "DELETE",
            "User/remove-favourite/{likeId}",
            "This endpoint should be used to remove an item from a users collection of favourite places"
        );
        $renderer->renderHeaderInformation(
            Array(
                "session_token" => "The logged in users current session token.",
                "device_id"     => "The id of the current device"
            )
        );
        $renderer->renderURIComponents(
            Array(
                "likeId" => "The id of the favourite place to be deleted"
            )
        );
        $renderer->renderResponseCodes(
            Array(
                "200" => "The favourite place was deleted successfully",
                "401" => "The current session was unset, login again",
                "409" => "The favourite could not be removed because it does not belong to the user deleting it"
            )
        );
        $navigation->addItem("Remove a Favourite Place", "deleteFavourite");
        ?>
    </section>
</section>


<?php
$navigation->renderNavigationBar();
?>
