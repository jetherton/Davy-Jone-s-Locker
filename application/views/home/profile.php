<div id="right_menu">
<ul>
<li>
	<a class="button" href="<?php echo url::base(). 'home/passing'; ?>"><?php  echo __("passing settings"); ?></a>
</li>
</ul>
</div>

<h2><?php echo __("profile header"); ?></h2>
<p><?php echo __("profile explanation");?></p>
<h4 class="whats_required"><?php echo __("whats required");?></h4>


<?php //define the US states array now

$states_array = array('Alabama'=>'Alabama',
'Alaska'=>'Alaska',
'American Samoa'=>'American Samoa',
'Arizona'=>'Arizona',
'Arkansas'=>'Arkansas',
'California'=>'California',
'Colorado'=>'Colorado',
'Connecticut'=>'Connecticut',
'Delaware'=>'Delaware',
'District of Columbia'=>'District of Columbia',
'Florida'=>'Florida',
'Georgia'=>'Georgia',
'Guam'=>'Guam',
'Hawaii'=>'Hawaii',
'Idaho'=>'Idaho',
'Illinois'=>'Illinois',
'Indiana'=>'Indiana',
'Iowa'=>'Iowa',
'Kansas'=>'Kansas',
'Kentucky'=>'Kentucky',
'Louisiana'=>'Louisiana',
'Maine'=>'Maine',
'Maryland'=>'Maryland',
'Massachusetts'=>'Massachusetts',
'Michigan'=>'Michigan',
'Minnesota'=>'Minnesota',
'Mississippi'=>'Mississippi',
'Missouri'=>'Missouri',
'Montana'=>'Montana',
'Nebraska'=>'Nebraska',
'Nevada'=>'Nevada',
'New Hampshire'=>'New Hampshire',
'New Jersey'=>'New Jersey',
'New Mexico'=>'New Mexico',
'New York'=>'New York',
'North Carolina'=>'North Carolina',
'North Dakota'=>'North Dakota',
'Northern Marianas Islands'=>'Northern Marianas Islands',
'Ohio'=>'Ohio',
'Oklahoma'=>'Oklahoma',
'Oregon'=>'Oregon',
'Pennsylvania'=>'Pennsylvania',
'Puerto Rico'=>'Puerto Rico',
'Rhode Island'=>'Rhode Island',
'South Carolina'=>'South Carolina',
'South Dakota'=>'South Dakota',
'Tennessee'=>'Tennessee',
'Texas'=>'Texas',
'Utah'=>'Utah',
'Vermont'=>'Vermont',
'Virginia'=>'Virginia',
'Virgin Islands'=>'Virgin Islands',
'Washington'=>'Washington',
'West Virginia'=>'West Virginia',
'Wisconsin'=>'Wisconsin',
'Wyoming'=>'Wyoming');

$countries_array = array('Afghanistan'=>'Afghanistan',
'Albania'=>'Albania',
'Algeria'=>'Algeria',
'Andorra'=>'Andorra',
'Angola'=>'Angola',
'Argentina'=>'Argentina',
'Armenia'=>'Armenia',
'Australia'=>'Australia',
'Austria'=>'Austria',
'Azerbaijan'=>'Azerbaijan',
'Bahamas'=>'Bahamas',
'Bahrain'=>'Bahrain',
'Bangladesh'=>'Bangladesh',
'Barbados'=>'Barbados',
'Belarus'=>'Belarus',
'Belgium'=>'Belgium',
'Belize'=>'Belize',
'Benin'=>'Benin',
'Bhutan'=>'Bhutan',
'Bolivia'=>'Bolivia',
'Bosnia-Herzegovina'=>'Bosnia-Herzegovina',
'Botswana'=>'Botswana',
'Brazil'=>'Brazil',
'Britain'=>'Britain',
'Brunei'=>'Brunei',
'Bulgaria'=>'Bulgaria',
'Burkina'=>'Burkina',
'Burma (official name Myanmar)'=>'Burma (official name Myanmar)',
'Burundi'=>'Burundi',
'Cambodia'=>'Cambodia',
'Cameroon'=>'Cameroon',
'Canada'=>'Canada',
'Cape Verde Islands'=>'Cape Verde Islands',
'Chad'=>'Chad',
'Chile'=>'Chile',
'China'=>'China',
'Colombia'=>'Colombia',
'Congo'=>'Congo',
'Costa Rica'=>'Costa Rica',
'Croatia'=>'Croatia',
'Cuba'=>'Cuba',
'Cyprus'=>'Cyprus',
'Czech Republic'=>'Czech Republic',
'Denmark'=>'Denmark',
'Djibouti'=>'Djibouti',
'Dominica'=>'Dominica',
'Dominican Republic'=>'Dominican Republic',
'Ecuador'=>'Ecuador',
'Egypt'=>'Egypt',
'El Salvador'=>'El Salvador',
'England'=>'England',
'Eritrea'=>'Eritrea',
'Estonia'=>'Estonia',
'Ethiopia'=>'Ethiopia',
'Fiji'=>'Fiji',
'Finland'=>'Finland',
'France'=>'France',
'Gabon'=>'Gabon',
'Gambia, the'=>'Gambia, the',
'Georgia'=>'Georgia',
'Germany'=>'Germany',
'Ghana'=>'Ghana',
'Greece'=>'Greece',
'Grenada'=>'Grenada',
'Guatemala'=>'Guatemala',
'Guinea'=>'Guinea',
'Guyana'=>'Guyana',
'Haiti'=>'Haiti',
'Holland (also Netherlands)'=>'Holland (also Netherlands)',
'Honduras'=>'Honduras',
'Hungary'=>'Hungary',
'Iceland'=>'Iceland',
'India'=>'India',
'Indonesia'=>'Indonesia',
'Iran'=>'Iran',
'Iraq'=>'Iraq',
'Ireland, Republic of'=>'Ireland, Republic of',
'Israel'=>'Israel',
'Italy'=>'Italy',
'Jamaica'=>'Jamaica',
'Japan'=>'Japan',
'Jordan'=>'Jordan',
'Kazakhstan'=>'Kazakhstan',
'Kenya'=>'Kenya',
'Korea see North Korea, South Korea'=>'Korea see North Korea, South Korea',
'Kuwait'=>'Kuwait',
'Laos'=>'Laos',
'Latvia'=>'Latvia',
'Lebanon'=>'Lebanon',
'Liberia'=>'Liberia',
'Libya'=>'Libya',
'Liechtenstein'=>'Liechtenstein',
'Lithuania'=>'Lithuania',
'Luxembourg'=>'Luxembourg',
'Macedonia'=>'Macedonia',
'Madagascar'=>'Madagascar',
'Malawi'=>'Malawi',
'Malaysia'=>'Malaysia',
'Maldives'=>'Maldives',
'Mali'=>'Mali',
'Malta'=>'Malta',
'Mauritania'=>'Mauritania',
'Mauritius'=>'Mauritius',
'Mexico'=>'Mexico',
'Moldova'=>'Moldova',
'Monaco'=>'Monaco',
'Mongolia'=>'Mongolia',
'Montenegro'=>'Montenegro',
'Morocco'=>'Morocco',
'Mozambique'=>'Mozambique',
'Myanmar see Burma'=>'Myanmar see Burma',
'Namibia'=>'Namibia',
'Nepal'=>'Nepal',
'Netherlands, the (see Holland)'=>'Netherlands, the (see Holland)',
'New Zealand'=>'New Zealand',
'Nicaragua'=>'Nicaragua',
'Niger'=>'Niger',
'Nigeria'=>'Nigeria',
'North Korea'=>'North Korea',
'Norway'=>'Norway',
'Oman'=>'Oman',
'Pakistan'=>'Pakistan',
'Panama'=>'Panama',
'Papua New Guinea'=>'Papua New Guinea',
'Paraguay'=>'Paraguay',
'Peru'=>'Peru',
'the Philippines'=>'the Philippines',
'Poland'=>'Poland',
'Portugal'=>'Portugal',
'Qatar'=>'Qatar',
'Romania'=>'Romania',
'Russia'=>'Russia',
'Rwanda'=>'Rwanda',
'Saudi Arabia'=>'Saudi Arabia',
'Scotland'=>'Scotland',
'Senegal'=>'Senegal',
'Serbia'=>'Serbia',
'Seychelles, the'=>'Seychelles, the',
'Sierra Leone'=>'Sierra Leone',
'Singapore'=>'Singapore',
'Slovakia'=>'Slovakia',
'Slovenia'=>'Slovenia',
'Solomon Islands'=>'Solomon Islands',
'Somalia'=>'Somalia',
'South Africa'=>'South Africa',
'South Korea'=>'South Korea',
'Spain'=>'Spain',
'Sri Lanka'=>'Sri Lanka',
'Sudan'=>'Sudan',
'Suriname'=>'Suriname',
'Swaziland'=>'Swaziland',
'Sweden'=>'Sweden',
'Switzerland'=>'Switzerland',
'Syria'=>'Syria',
'Taiwan'=>'Taiwan',
'Tajikistan'=>'Tajikistan',
'Tanzania'=>'Tanzania',
'Thailand'=>'Thailand',
'Togo'=>'Togo',
'Trinidad and Tobago'=>'Trinidad and Tobago',
'Tunisia'=>'Tunisia',
'Turkey'=>'Turkey',
'Turkmenistan'=>'Turkmenistan',
'Tuvali'=>'Tuvali',
'Uganda'=>'Uganda',
'Ukraine'=>'Ukraine',
'United Arab Emirates (UAE)'=>'United Arab Emirates (UAE)',
'United Kingdom (UK)'=>'United Kingdom (UK)',
'United States of America (USA)'=>'United States of America (USA)',
'Uruguay'=>'Uruguay',
'Uzbekistan'=>'Uzbekistan',
'Vanuata'=>'Vanuata',
'Vatican City'=>'Vatican City',
'Venezuela'=>'Venezuela',
'Vietnam'=>'Vietnam',
'Wales'=>'Wales',
'Western Samoa'=>'Western Samoa',
'Yemen'=>'Yemen',
'Yugoslavia'=>'Yugoslavia',
'Zaire'=>'Zaire',
'Zambia'=>'Zambia',
'Zimbabwe'=>'Zimbabwe');

?>


<?php if(count($errors) > 0 )
{
?>
	<div class="errors">
	<?php echo __("error"); ?>
		<ul>
<?php 
	foreach($errors as $error)
	{
?>
		<li> <?php echo $error; ?></li>
<?php
	} 
	?>
		</ul>
	</div>
<?php 
}
?>

<?php if(count($messages) > 0 )
{
?>
	<div class="messages">
		<ul>
<?php 
	foreach($messages as $message)
	{
?>
		<li> <?php echo $message; ?></li>
<?php
	} 
	?>
		</ul>
	</div>
<?php 
}
?>

<?php echo Kohana_Form::open(); ?>
	<table>
		<tr>
			<td>
				<?php echo Form::label('email_address', __("email address"));  ?>
			</td>
			<td>
				<?php echo Form::input('email', $user->email, array('id'=>'email'));?>
			</td>
			
			<td>
				<?php echo Form::label('gender', __("gender"));  ?>
			</td>
			<td>
				<?php echo Form::select('gender', array(1=>'Male', 2=>'Female'), $user->gender);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('user_name', __("user name"));  ?>
			</td>
			<td>
				<?php echo Form::input('username', $user->username);?>
			</td>
			
			<td>
				<?php echo Form::label('address1', __("address"));  ?>
			</td>
			<td>
				<?php echo Form::input('address1', $user->address1);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('first_name', __("first name"));  ?>
			</td>
			<td>
				<?php echo Form::input('first_name', $user->first_name);?>
			</td>
			<td>
				
			</td>
			<td>
				<?php echo Form::input('address2', $user->address2);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('middle_name', __("middle name"));  ?>
			</td>
			<td>
				<?php echo Form::input('middle_name', $user->middle_name);?>
			</td>
				<td>
				<?php echo Form::label('city', __("city"));  ?>
			</td>
			<td>
				<?php echo Form::input('city', $user->city);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('last_name', __("last name"));  ?>
			</td>
			<td>
				<?php echo Form::input('last_name', $user->last_name);?>
			</td>
			
			<td>
				<?php echo Form::label('state', __("state"));  ?>
			</td>
			<td>
				<?php echo Form::select('state',$states_array, $user->state);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('current_password', __("current password"));  ?>
			</td>
			<td>
				<?php echo Form::password('current_password');?>
			</td>
			
			<td>
				<?php echo Form::label('zip', __("zip"));  ?>
			</td>
			<td>
				<?php echo Form::input('zip', $user->zip);?>
			</td>
		</tr>	
		<tr>
			<td>
				<?php echo Form::label('new_password', __("new password"));  ?>
			</td>
			<td>
				<?php echo Form::password('password');?>
			</td>
			<td>
				<?php echo Form::label('dob', __("dob"));  ?>
			</td>
			<td>
				<?php echo Form::input('dob', date("m/d/Y",strtotime($user->dob)), array('id'=>'dob', 'style'=>'width:100px;'));?>
			<?php echo '<script type="text/javascript">
							$().ready(function() {
								$("#dob").datepicker({ 
									showOn: "both", 
									buttonImage: "'.url::base(). 'media/img/icon-calendar.gif", 
									buttonImageOnly: true 
								});
							});
						</script>'; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('new_password_again', __("new password again"));  ?>
			</td>
			<td>
				<?php echo Form::password('password_confirm');?>
			</td>
			<td>
				<?php echo Form::label('citizenship', __("citizenship"));  ?>
			</td>
			<td>
				<?php echo Form::select('citizenship', $countries_array, $user->citizenship);?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo Form::label('profile_picture', __("profile picture"));  ?>
			</td>
			<td>				
				<div id="profile_image">
					<?php if($user->picture != null){?>
					<img src="<?php echo URL::base().'uploads/'.$user->picture;?>"/>
					<?php }?>
				</div>
				<div id="image_uploader">		
					<noscript>			
						<p>Please enable JavaScript to use file uploader.</p>
						<!-- or put a simple form for upload here -->
					</noscript>         
				</div>
			</td>
			<td>
				
			</td>
			<td>
				
			</td>
		</tr>
	</table>
	
	
	
	<br/>
	<br/>
	<?php echo Form::submit("profile_form",  __("update profile")); ?>
			
<?php echo Kohana_Form::close(); ?>
