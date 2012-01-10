<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(

	//misc
	'yes' => 'Yes',
	'no' => 'No',
	'n/a' => 'Not Applicable',
	'n/a explain' => 'Does not appy, and thus intentionally left blank',

	//Header
	'site name'=>'Ekphora',
	'tagline'=>'Where you store your last wishes',


	//Register Page
	'email address'=>'Email Address:',
	'first name'=>'First Name:',
	'last name'=>'Last Name:',
	'password'=>'Password:',
	'password again'=>'Password Again:',
	'read terms of use'=>'I have read and agree to the terms of use.',
	'register'=>"Register",
	'register explanation'=>"Fill out the fields below and click submit to register",	
	'user name'=>'User Name:',	
	
	//profiel page
	'profile header'=>'Update Your Profile',
	'profile explanation'=>'Use the fields below to update your profile information. <br/> You must re-type your password to confirm the changes you want to make.<br/>Leave the "New Password" field blank if you do not wish to change your current password',
	'current password'=>'Current Password*:',
	'new password'=>'New Password:',
	'new password again'=>'New Password Again:',
	'update profile'=>'Update',
	'profile update successful'=>'Profile Updated Successfully',

	//Login Page
	'login'=>"Login",
	'login explanation'=>"Enter your user name and password to login",
	'incorrect login'=>"I'm sorry, that user name and password combination is not recognized",

	//logout Page
	'logout'=>"Logout",
	'logout explanation'=> "You have been logged out",
	'come on back now'=> "Come back and see us",

	//profile page
	'profile'=>'Profile',

	//Errors
	'must agree to terms of use'=>"You must aggree to the terms of use.",
	'error'=>"Error",

	//login / logout div
	'welcome'=>'Welcome',
	'or'=>'or',

	//home page
	'home'=>'Home',
	'updates'=>'Updates',
	'welcome home :user'=>'Welcome :first_name :last_name',	
	
	//universal
	'whats required'=>'Fields with a * are required',
	
	//Wish
	'wish' => 'Wish',
	'add' => 'Add',
	'wishes' => 'Wishes',
	'wishes explanation' => 'These are the wishes you have created',
	'add wish' => 'Add Wish',
	'add wish explanation' => 'Enter the details of your new wish',
	'edit wish' => 'Edit Wish',
	'edit wish explanation' => 'Change the details of your wish',
	'title'=>'Title',
	'wish added successfully'=>'Wish Added Successfully',
	'wish edited successfully'=>'Wish Edited Successfully',
	'tags'=>'tags',
	'type'=>'Type',
	'last edited'=>'Last modified',	
	'you have no wishes'=>'you have no wishes',
	'you have no'=>'you have no',
	'has shared no wishes'=>' has not shared any wishes with you.',
	'location'=>'Location',
	'pictures'=>'Pictures',
	'files'=>'files',
	'who can view'=>'Who Can View',
	'delete wish' => 'Delete Wish',
	'Are you sure you want to delete wish'=>'Are you sure you want to delete this wish?',
	'your wishes'=>'Your Wishes',
	'wishes :friend has shared with you'=>'Wishes :friend has shared with you',
	'wishes you shared with :friend'=>'Wishes you have shared with :friend',
	'you have not shared any wishes with :friend'=>'You have not shared any wishes with :friend',
	'by'=>'By',
	'notes'=>'Notes',

	//friends
	'friend'=>'Friend',
	'friends'=>'Friends',
	'friends explanation'=>'These are the people you have set as friends or family.',
	'you have no friends'=>'You have no friends. Try adding some.',
	'add friend'=>'Add Friend',
	'search on ekphora'=>'Search for people on Ekphora',
	'search'=>'Search',
	'do you want to add'=>'Do you want to add ',
	'as a friend'=>' as a friend',
	'error occured while trying to add user as friend'=>'An error occured in our system while trying to add a new friend to your profile. Please try again.',
	'friend view'=> 'Info on your friend and the wishes he or she has shared with you',
	'relationship'=>'Relationship',
	'my friend' => 'My Friend',
	'his her friend' => 'His/Her Friend',
	'both friends' => 'Both Friends',
	'remove your friend' => 'Remove Your Friendship',
	'are you sure delete your friend' => 'Are you sure you want to delete this friend? If you delete this friend they will not be able to see any of your wishes. Friendships are not easily disolved.',
	'add :friend as friend'=>'Add :friend as friend.',

	//groups
	'groups'=>'Groups',

	//updates
	'update :user added you as a friend :id'=>'<a href="'.url::base().'home/friends/view?id=:id">:user</a> added you as a friend.',
	'update :user sent you :wish :wish-id :user-id :user'=>'<a href="'.url::base().'home/friends/view?id=:user-id">:user</a> shared wish <a href="'.url::base().'home/wish/view?id=:wish-id">:wish</a> with you.',

	//dates
	'a few seconds ago'=>'A few seconds ago',
	':hours hours ago'=>':hours hours ago',
	':minutes minutes ago'=>':minutes minutes ago',
	
	//pictures
	'delete picture'=>'Delete',
	'delete file'=>'Delete',
	'insert'=>'Insert',
	'link'=>'Link',
	'thumbnail'=>'Thumbnail',
	'passport'=>'Passport',
	'full size'=>'Full Size',
	'wishes pictures' => 'Pictures',
	'wishes files' => 'Files',
	
	//map
	'search map'=>'Search Map: ',
	'use location'=>'Use Location',

	//categories
	'categories'=>'Categories',
	'category'=>'Category',
	'categories explanation'=>'Use this page to add, edit, and delete categories',
	'description'=>'Description',
	'you have no categories'=>'You have no categories',
	'add/edit category'=>'Add / Edit Category',
	'add edit'=>'Add/Edit',
	'order'=>'Order',
	'actions'=>'Actions',
	'are you sure you want to delete category'=>'Are you sure you want to delete this category?',
	'edit'=>'Edit',
	'delete'=>'Delete',
	'you can not delete that category'=>'You cannot delete that category, it is being used by one or more forms. You must change those forms to not use this category first.',
	
	//forms
	'forms'=>'Forms',
	'forms explanation'=>'Use this page to add, edit, and delete forms',
	'are you sure you want to delete category'=>'Are you sure you want to delete this form?',
	'you have no forms'=>'You have no forms',
	'add form'=>'Add Form',
	'edit form'=>'Edit Form',
	'form edit explanation'=>'Use this page to edit a form',
	'form fields'=>'Form Fields',
	'you have no form fields'=>'You have no form fields',
	'changes saved'=>'Changes Saved.',
	'form deleted'=>'Form Deleted.',
	
	//form fields
	'text input'=>'Text Box',
	'text area input'=>'Text Area',
	'date input'=>'Date',
	'radio input'=> 'Radio Buttons',
	'check box input'=>'Check Boxes',
	'dropdown input'=>'Drop Down Box',
	'password input'=>'Password Text Box',
	'add field'=>'Add Field',
	'edit form field'=>'Edit Form Field',
	'add form field'=>'Add Form Field',
	'form field edit explanation'=>'Use this form to edit a form field that users will use to fill out their wishes',
	'add option'=>'Add / Edit Option',
	'form options'=>'Form Options',
	'you have no options'=>'You have no options',
	'type'=>'Type',
	'required'=>'Required',
	'back to form'=>'Back to Form',
	'is a required field'=>'is a required field.',
	'cannot be longer than 255 characters'=>'cannot be longer than 255 characters.',
	
	//form field options
	'Must save field before adding options'=>'Sorry, you must first save a new field before you can add options to it',
	'option deleted'=>'Option Deleted',
	
);


