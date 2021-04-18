#!/usr/bin/tclsh
# Program Name  : Indexer
# Version       : 1.00.D
# Time          : June 24, 2004 to July 15, 2004
# Records       : Believe it or not, this is my first complete Tcl/Tk program
#				: Longest program in single sitting
#				: Longest first Version
#				: Longest first program in any language
#				: When this program is larger than 2377, it will be the single lagrest program.
# 
##########################################################################################

#Some Global Vars
set version {1.00.D}
#Settings
set start_folder "C:/"
set home_folder [file dirname $argv0]
set themes_folder "$home_folder/Themes"
set user_folder "$home_folder/User Files"

#Things needed for themes
set theme_name "Basic"
set theme_section "Basic Index"
set theme_desc "This will sort all files according to the folders they are in and print show the links according to the folders they are in."
#Code of themes
set start_code ""
set link_code ""
set struct_in_code ""
set struct_out_code ""
set level_1_code ""
set level_2_code ""
set level_3_code ""
set level_4_code ""
set insert_folder ""
set insert_folder_n ""
set insert_file ""
set insert_file_n ""
set insert_letter ""
set end_code ""
set files ""
set path ""
set filters ""

############################### Themes Section ##########################
set left_selection 0
set themes ""
# The Format :{ {Section} {Theme name} {Description} }
# {
# { {Simple Index} {Folder-wise} {This will sort all files according to the folders they are in and print the name of the folders in the HTML file} {File Name} }
# { {Simple Index} {Alphabetical} {This will list all files alphabetically. Files which start with 'A' will come first under the heading 'A', then 'B' etc.} {File Name} }
# { {Simple Index} {Folder-wise with space} {Same as the folder-wise option, but in this case, each time the folder depth is increased, some spaces will be added to the HTML file, make it much easier to understand.} {File Name} }
# }

# Function : loadThemes
# Find all the themes from the themes folder and make it into the 'themes' format. Each
# 		folder in the 'Themes' folder is a Section and each file in any section is a 
#		theme. So first all the directories are located and then all the themes 
#		within it are processed.
proc loadThemes { page } {
	global themes themes_folder

	cd "$themes_folder"
	set files [lsort [glob -nocomplain "*"]]
	set total_folders 0
	#Find all directories(Sections) and put it in a array
	foreach i $files {
		if { $i != "$themes_folder." && $i != "$themes_folder.." } {
			if {[file isdirectory $i]} {
				#If the specifed file is a directory, add it to the list of
				#	directories of which's file listing we should get.
				lappend dirs $i
				incr total_folders
			}
  		}
	}
	
	set flag 0
	#Continue finding the themes till all folders are done
	while { $flag < $total_folders } {
		#Get the name of the folder
		set folder [lindex $dirs $flag]
		cd "$themes_folder/$folder"
		#Get the list of themes. They have the extension '.thm'
		set files [lsort [glob -nocomplain "*.thm"]]
		foreach i $files {
			if { $i != "$themes_folder/$folder/." && $i != "$themes_folder/$folder/.." } {
				if {![file isdirectory $i]} {
					#Upon getting a theme, open it
					set in_file [open "$i" r]
					seek $in_file 0 start
					#Read the full content of the theme and get it line by line
					set content [read $in_file]
					#Closing the file
					close $in_file
					
					#Get it as lines
					#Not all the get lines after @desc are not wanted. I put them because
					#	we wanted the 'flager' to be 1 if valid theme info is NOT there.
					set lines [split $content "\n"]
					foreach line $lines {
						set parts [split $line "="]
						set flager 0
						switch [lindex $parts 0] {
							"@name"				{ set name [getLine $line] }
							"@section"			{ set section [getLine $line] }
							"@desc"				{ set desc [getLine $line] }
							"@start_code"		{ set start_code [getLine $line] }
							"@link_code"		{ set link_code [getLine $line] }
							"@struct_in_code"	{ set struct_in_code [getLine $line] }
							"@struct_out_code"	{ set struct_out_code [getLine $line] }
							"@level_1_code"		{ set level_1_code [getLine $line] }
							"@level_2_code"		{ set level_2_code [getLine $line] }
							"@level_3_code"		{ set level_3_code [getLine $line] }
							"@level_4_code"		{ set level_4_code [getLine $line] }
							"@insert_folder"	{ set insert_folder [getLine $line] }
							"@insert_folder_n"	{ set insert_folder_n [getLine $line] }
							"@insert_file"		{ set insert_file [getLine $line] }
							"@insert_file_n"	{ set insert_file_n [getLine $line] }
							"@insert_letter"	{ set insert_letter [getLine $line] }
							"@end_code"			{ set end_code [getLine $line] }
							"@files"			{ set files [getLine $line] }
							"@path"				{ set path [getLine $line] }
							"@filters"			{ set path [getLine $line] }
							default		{ set flager 1 }
						}

						#If it is not a theme related line, append it to the last theme Info
						if { $flager } {
							if { ([string index $line 0]=="#") } {
								#This happens when the line is a comment
								break
							} else {
								if { $line != "" || $line != "\n" } {
									#The problem causers. { and } makes errors.
									if { [string match "*\{*" $line] } {
										set line [changeChar $line "\{" "\\\{" ]
									}
									if { [string match "*\}*" $line] } {
										set line [changeChar $line "\}" "\\\}" ]
									}
									
									set str "append $last_name \{\n$line\}"
								} else {
									set str "append $last_name \n"
								}
								eval $str
							}
						} else {
							#Get the last done variable. Throw the @ away.
							regexp "^\@(.*)$" [lindex $parts 0] unwanted last_name
						}
					}

##############################################
#THEME FILE STRUCTURE
#
# name=Folder-wise
# section=Simple Index
# desc=This will sort all files according to the folders they are in and print the name of the folders in the HTML file
#
##############################################

					#Make the stucture - Section, Name, Description and File Name.
					set this_theme ""
					lappend this_theme $section
					lappend this_theme $name
					lappend this_theme $desc
					lappend this_theme "$themes_folder/$folder/$i"
					lappend themes $this_theme
	  			}
		  	}
		}
		#Increment the folder number for the 'dirs' list
		incr flag
	}
}

# Function : themeFinder
# This happens whenever the user clicks on a section. This will find which all themes 
# 		are there in that section and put those themes in the right list box
proc themeFinder { page } {
	global themes left_selection
	set left_selection [$page.slb_l curselection]
	#Due to some reason, when some one click on the right list box the selection in
	#		left box disappears. So make it a global variable as it is needed for 
	#		themeInfo methord
	set section_name [$page.slb_l get $left_selection]

	foreach this_theme $themes {
		if {[lindex $this_theme 0] == $section_name} {
			lappend txt [lindex $this_theme 1]
		}
	}

	$page.slb_r clear
	foreach i $txt {		
		$page.slb_r insert end "$i"
	}
}

# Function : getLine
# If there are multiple '=' in one line, return every thing after the first '='
# Arguments: line - The string containing theme data - the line to be processed
# Return   : data
proc getLine { line } {
	set data ""
	set parts [split $line "="]
	if {[llength $parts] > 2} {
		for {set i 1} { $i<[llength $parts] } { incr i } {
			if {$i == 1} { append data "[lindex $parts $i]"
			} else { append data "=[lindex $parts $i]" }
		}
	} else { set data "[lindex $parts 1]" }

	return $data
}

# Function : selectTheme
# This happens every time a theme is clicked. It will store all the theme's data into
# 		global variables. This is called from themeInfo
# Arguments: theme - The structure in which the theme that is clicked is there
proc selectTheme { theme } {
	#Get all global things needed for the theme. The declarations are found on top of file.
	global theme_name theme_section theme_desc
	global start_code link_code struct_in_code struct_out_code
	global level_1_code level_2_code level_3_code level_4_code
	global insert_folder insert_folder_n insert_file insert_file_n insert_letter 
	global end_code files path filters
	
	#Re-Initialize all variables. Otherwise the info of last selected theme will be 
	#		carried over to the current theme.
	set theme_name "Basic"
	set theme_section "Basic Index"
	set theme_desc ""
	#Code of themes
	set start_code ""
	set link_code ""
	set struct_in_code ""
	set struct_out_code ""
	set level_1_code ""
	set level_2_code ""
	set level_3_code ""
	set level_4_code ""
	set insert_folder ""
	set insert_folder_n ""
	set insert_file ""
	set insert_file_n ""
	set insert_letter ""
	set end_code ""
	set files ""
	set path ""
	set filters ""

	#Get the Manual page access modifier, and reset them so that the manual pages
	#	can be changed. For more info, see function 'defaulter'
	global zero one two three four five six seven tp2
	set zero 0
	set one 0
	set two 0
	set three 0
	set four 0
	set five 0
	set six 0
	set seven 0

	$tp2.tnb_manual view "Introduction"

	set file_name [lindex $theme 3]
	set in_file [open "$file_name" r]
	seek $in_file 0 start
	#Read the full content of the theme and get it line by line
	set content [read $in_file]
	#Closing the file
	close $in_file
	
	set last_name "name"
	#Get it as lines
	set lines [split $content "\n"]
	foreach line $lines {
		set parts [split $line "="]
		set after_equal [getLine $line]
		set flager 0
		switch [lindex $parts 0] {
			"@name"				{ set theme_name $after_equal }
			"@section"			{ set theme_section $after_equal }
			"@desc"				{ set theme_desc $after_equal }
			"@start_code"		{ set start_code $after_equal }
			"@link_code"		{ set link_code $after_equal }
			"@struct_in_code"	{ set struct_in_code "\n$after_equal" }
			"@struct_out_code"	{ set struct_out_code $after_equal }
			"@level_1_code"		{ set level_1_code $after_equal }
			"@level_2_code"		{ set level_2_code $after_equal }
			"@level_3_code"		{ set level_3_code $after_equal }
			"@level_4_code"		{ set level_4_code $after_equal }
			"@insert_folder"	{ set insert_folder $after_equal }
			"@insert_folder_n"	{ set insert_folder_n $after_equal }
			"@insert_file"		{ set insert_file $after_equal }
			"@insert_file_n"	{ set insert_file_n $after_equal }
			"@insert_letter"	{ set insert_letter $after_equal }
			"@end_code"			{ set end_code "\n$after_equal" }
			"@files"			{ set files $after_equal }
			"@path"				{ set path $after_equal }
			"@filters"			{ set filters $after_equal }
			default				{ set flager 1 }
		}

		#If it is not a theme related line, append it to the last theme Info
		if { $flager } {
			if { ([string index $line 0]=="#") } {
				#This happens when the line is a comment
				break
			} else {
				if { $line != "" || $line != "\n" } {
					#The problem causers. { and } makes errors.
					if { [string match "*\{*" $line] } {
						set line [changeChar $line "\{" "\\\{" ]
					}
					if { [string match "*\}*" $line] } {
						set line [changeChar $line "\}" "\\\}" ]
					}

					set str "append $last_name {\n$line}"
				} else {
					set str "append $last_name \n"
				}
				eval $str
			}
		} else {
			#Get the last done variable. Throw the @ away.
			regexp "^\@(.*)$" [lindex $parts 0] unwanted last_name
		}
	}
	
	#If any variable has the text "INVALID" make it empty
	if {$struct_in_code=="INVALID"} { set struct_in_code "" }
	if {$level_1_code == "INVALID"} { set level_1_code "" }
	if {$level_2_code == "INVALID"} { set level_2_code "" }
	if {$level_3_code == "INVALID"} { set level_3_code "" }
	if {$level_4_code == "INVALID"} { set level_4_code "" }

	#Some Variable should not have \n in them - the path or filter for example.
	set path [changeChar $path "\n" ""]
	set filters [changeChar $filters "\n" ""]
}

# Function : themeInfo
# This function will be activated when the user clicks on the name of any theme. It
# 		will search the 'themes' list for the discription of that them and show it in
#		a textarea
proc themeInfo { page } {
	global themes left_selection start_code
	set right_selection [$page.slb_r curselection]	
	set section_name [$page.slb_l get $left_selection]
	set theme_name [$page.slb_r get $right_selection]

	foreach this_theme $themes {
		if {[lindex $this_theme 0] == $section_name} {
			if {[lindex $this_theme 1] == $theme_name} {
				selectTheme $this_theme
				$page.txt_details delete 1.0 end
				$page.txt_details insert end "[lindex $this_theme 2]"
				break
			}
		}
	}
}

# Function : populateSections
# This will put the name of all sections in the left listbox and call for the filling
# 	of the right list box after selecting the first element of the left listbox
proc populateSections { page } {
	global themes
	#Some value must be assigned to 'last_name' otherwise there will be an error
	set last_name "x"
	foreach this_theme $themes {
		set name [lindex $this_theme 0]
		if { ($name!="") && ($name!=$last_name) } {
			lappend section [lindex $this_theme 0]
			set last_name $name
		}
	}
	set i 0
	foreach name $section {
		$page.slb_l insert $i $name
		incr i
	}

	#This selects the Catagory.
	$page.slb_l selection set 0
	themeFinder $page
}

# Function : refreshThemes
# This will reload all the themes from disk after clearing all the fields
proc refreshThemes { page } {
	global themes
	set themes ""
	$page.slb_l clear
	$page.slb_r clear
	$page.txt_details delete 1.0 end
	loadThemes $page
	populateSections $page	
}

# Function  : changeChar
# Seaches for all cases of '$char's occurence in $str and chages all of them to '$toChar'
#		Used to change '{' to '\}' and such like.
# Arguments : str - The string to be processed
#			: char - The charector to be changed
#			: toChar - The charector that should be inserte in the place of '$char'
# Return    : result - The String in which the substitutions are made.
proc changeChar { str char toChar} {
	set temperory ""
	if {[string length $char] == 1 } { 
		for {set l 0} {$l<[string length $str]} {incr l} {
			set letter [string index $str $l]
			if { $letter == "$char" } {
				append temperory "$toChar"
			} else {
				append temperory $letter
			}
		}
	} else {
		#If there is 2 charectors in the 'char' replace both with the $toChar
		for {set l 0} {$l<[string length $str]} {incr l} {
			set letter [string index $str $l]
			set latter [string index $str [expr $l + 1]]
			if { $letter == "[string index $char 0]" && $latter == "[string index $char 1]"} {
				append temperory "$toChar"
				incr l
			} else {
				append temperory $letter
			}
		}
	}
	return $temperory
}

######################## Theme Manual Settings ########################

#The Global variable that make it sure that the 'defaulter' function is only done once
#		 for all themes
set zero 0
set one 0
set two 0
set three 0
set four 0
set five 0
set six 0
set seven 0

# Function : getDefault
# If the argument given as 'variable_code' is empty, return the 'default_code' else 
#		return 'variable_code'
# Arguments:	variable_code - The global Code for that field
#				default_code  - The default code. This returned if variable_code is empty
# Returns  : $value
proc getDefault { default_code variable_code } {
	if { $variable_code == "" } {
		set value $default_code
	} elseif {$variable_code == "INVALID"} {
		set value ""
	} else {
		set value $variable_code
	}
	return $value
}
# Function : defaulter
# This will take the page number and get al the variables associated with that page.
# 		Then it will put all the data in their respective places. It runs every time a
#		tab is clicked for the first time.
# Arguments : 	page_no - The number of the page that is clicked
proc defaulter { page_no } {
	global themes_folder
	#Get the page in question
	switch $page_no {
		0	{
		#Introduction
			global tm0 filters zero
			global theme_name theme_desc
			set tm $tm0
			#Make sure this is only run once
			if { $zero < 1 } {
				$tm.ent_filter delete 0 end
				$tm.ent_filter insert end "$filters"
				
				#Display info about the theme here.
				$tm.lbl_intro_heading configure -text "$theme_name"
				$tm.lbl_theme_intro configure -text "Manual Settings for '$theme_name'.\n$theme_desc"
			}
			incr zero
		}
		1	{
		#Page Start
			global tm1 start_code one
			set tm $tm1
			#Make sure this is only run once
			if { $one < 1 } {
				$tm.txt_start_code delete 1.0 end
				set code [getDefault "<HTML><HEAD>\n<TITLE>%Title%</TITLE>\n<STYLE>\n<!--\nA { COLOR:blue; TEXT-DECORATION:none; }\nA:hover { COLOR:red;}\n// -->\n</STYLE>\n</HEAD>\n<BODY>\n<H1 ALIGN=\"CENTER\">%Title%</H1>\n" $start_code]
				
				#To solve some problems, I had to add '\' to the '\{'s. Take them out.
				if { [string match "*\\\{*" $code] } {
					set code [changeChar $code "\\\{" "\{"]
				}
				if { [string match "*\\\}*" $code] } {
					set code [changeChar $code "\\\}" "\}" ]
				}
				
				$tm.txt_start_code insert end "$code"
			}
			incr one
		}
		2	{
		#Links
			global tm2 two link_code
			set tm $tm2
			#Make sure this is only run once
			if { $two < 1 } {
				$tm.txt_link_code delete 1.0 end
				$tm.txt_link_code insert end [getDefault "<A HREF=\"%LINK%\">%FILE_NAME%</A><BR>" $link_code]
			}
			incr two
		}
		3	{
		#Structure
			global tm3 three struct_in_code struct_out_code
			set tm $tm3
			#Make sure this is only run once
			if { $three < 1 } {
				$tm.txt_structure_1 delete 1.0 end
				$tm.txt_structure_1 insert end [getDefault "%Level_Code%" $struct_in_code]
				$tm.txt_structure_2 delete 1.0 end
				$tm.txt_structure_2 insert end [getDefault "" $struct_out_code]
			}
			incr three
		}
		4	{
		#Levels
			global tm4 four
			global level_1_code level_2_code level_3_code level_4_code
			set tm $tm4
			#Make sure this is only run once
			if { $four < 1 } {
				$tm.txt_level_1 delete 1.0 end
				$tm.txt_level_1 insert end [getDefault "<H3>%Folder_Name%</H3>" $level_1_code]
				$tm.txt_level_2 delete 1.0 end
				$tm.txt_level_2 insert end [getDefault "<H4>%Folder_Name%</H4>" $level_2_code]
				$tm.txt_level_3 delete 1.0 end
				$tm.txt_level_3 insert end [getDefault "<B>%Folder_Name%</B><BR>" $level_3_code]
				$tm.txt_level_4 delete 1.0 end
				$tm.txt_level_4 insert end [getDefault "<I>%Folder_Name%</I><BR>" $level_4_code]
			}
			incr four
		}
		5	{
		#Insertions
			global tm5 five
			global insert_folder insert_folder_n insert_file insert_file_n insert_letter
			set tm $tm5
			#Make sure this is only run once
			if { $five < 1 } {
				if { $insert_folder == "" } {
					$tm.ent_insert_1 delete 0 end
					$tm.txt_insert_1 delete 1.0 end
					$tm.ent_insert_1 configure -state disabled
					$tm.txt_insert_1 configure -state disabled
				} else {
					#To solve some problems, I had to add '\' to the '\{'s. Take them out.
					if { [string match "*\\\{*" $insert_folder] } {
						set insert_folder [changeChar $insert_folder "\\\{" "\{"]
					}
					if { [string match "*\\\}*" $insert_folder] } {
						set insert_folder [changeChar $insert_folder "\\\}" "\}" ]
					}
					
					$tm.txt_insert_1 delete 1.0 end
					$tm.ent_insert_1 delete 0 end
					$tm.txt_insert_1 insert end $insert_folder
					$tm.ent_insert_1 insert end $insert_folder_n
				}

				if { $insert_file == "" } {
					$tm.txt_insert_2 delete 1.0 end
					$tm.ent_insert_2 delete 0 end
					$tm.ent_insert_2 configure -state disabled
					$tm.txt_insert_2 configure -state disabled
				} else {
					$tm.txt_insert_2 delete 1.0 end
					$tm.ent_insert_2 delete 0 end
					$tm.txt_insert_2 insert end $insert_file
					$tm.ent_insert_2 insert end $insert_file_n
				}

				if { $insert_letter == "" } {
					$tm.txt_insert_3 delete 1.0 end
					$tm.txt_insert_3 configure -state disabled
				} else {
					$tm.txt_insert_3 delete 1.0 end
					$tm.txt_insert_3 insert end $insert_letter
				}
			}
			incr five
		}
		6	{
		#Page End
			global tm6 six end_code
			set tm $tm6
			#Make sure this is only run once
			if { $six < 1 } {
				$tm.txt_end_code delete 1.0 end
				$tm.txt_end_code insert end [getDefault "\n</BODY></HTML>" $end_code]
			}
			incr six
		}
		7	{
		#Files
			global tm7 seven files path
			set tm $tm7
			#Make sure this is only run once
			if { $seven < 1 } {
				set parts [split $files "\n"]
				$tm.slb clear
				foreach part $parts {
					set file_name "$themes_folder/$part"
					if {[file exists $file_name]} {
						$tm.slb insert end "$file_name"
					} else {
						if {$file_name!="" || $file_name!="\n"} {
							tk_messageBox -message "The file \"$file_name\" can't be found in the location specifed in the theme. This is required for this theme to function properly." -icon warning
						}
					}
				}
				$tm.ent_path delete 0 end
				$tm.ent_path insert end "$path"
			}
			incr seven
		}
	}
}

# Function : insertCode
# This function will take what is to be inserted from the drop down menu and insert it 
# 		into the specified area.
# Arguments : 	tm - the page where the elementst are found
#				name - name of the field into which text must be inserted
#				inserter - the name of the dropdown menu
proc insertCode { tm name inserter } {
	global insert_into
	set insert [$tm.$inserter get]
	if { $insert != "Insert"} {
		set insert "%$insert%"
		#If the invalid argument is not passed, other pages will do this too.
		if { $insert_into != "" && $name == "invalid" } {
			set name $insert_into
		}
		#If the 'Letter' is inserted into anything other than new letter field
		if { ($name != "txt_insert_3") && ($insert == "%Letter%") } {
			tk_messageBox -message "The 'Letter' insertion can only be made in 'At New Letter' field"
			return
		}
		#The insertions are done
		$tm.$name insert insert $insert
	}
}


####################################### Saving Themes #####################################

# Function : saveTheme
# This will save all the changes you made to a new theme that will be stored
#		in the 'User' folder in the Themes directory.
proc saveTheme { page } {
	global themes_folder 
	#Get all global things needed for the theme. The declarations are found on top of file.
	global start_code link_code struct_in_code struct_out_code 
	global level_1_code level_2_code level_3_code level_4_code 
	global insert_folder insert_folder_n insert_file insert_file_n insert_letter
	global end_code filters
	#Get all the pages
	global tm0 tm1 tm2 tm3 tm4 tm5 tm6 tm7
	
	set theme_name [$page.ent_theme_name get]
	#If there is no name, ask user to enter it and get out of the function
	if {$theme_name==""} {
		tk_messageBox -message "Please enter a name for the theme"
		return
		}
	set theme_desc [$page.txt_theme_desc get 1.0 end]
	if { ($theme_desc=="\n") || ($theme_desc=="") } {
		tk_messageBox -message "Please enter a description for the theme"
		return
	}
	
	#Get the settings that user has inputed
	#Page Start
	set start_code [$tm1.txt_start_code get 1.0 end]
	#Links
	set link_code [$tm2.txt_link_code get 1.0 end]
	#Structure - Folder in and out
	set struct_in_code  [$tm3.txt_structure_1 get 1.0 end]
	#The Alphabetics don't need struct_in_code
	if {$struct_in_code == ""} { set struct_in_code "INVALID" }
	set struct_out_code [$tm3.txt_structure_2 get 1.0 end]
	#Levels
	set level_1_code [$tm4.txt_level_1 get 1.0 end]
	set level_2_code [$tm4.txt_level_2 get 1.0 end]
	set level_3_code [$tm4.txt_level_3 get 1.0 end]
	set level_4_code [$tm4.txt_level_4 get 1.0 end]
	if {$level_1_code == ""} { set level_1_code "INVALID" }
	if {$level_2_code == ""} { set level_2_code "INVALID" }
	if {$level_3_code == ""} { set level_3_code "INVALID" }
	if {$level_4_code == ""} { set level_4_code "INVALID" }

	#Insersions
	#Folder
	set insert_folder [$tm5.txt_insert_1 get 1.0 end]
	#Asking a disabled item for content with 'cget' is asking for error.
	set state [$tm5.ent_insert_1 cget -state]
	if {$state != "disabled" } {
		set insert_folder_n [$tm5.ent_insert_1 get]
	} else { set insert_folder_n "\n"	}

	#File
	set insert_file [$tm5.txt_insert_2 get 1.0 end]
	set state [$tm5.ent_insert_2 cget -state]
	if {$state != "disabled" } {
		set insert_file_n [$tm5.ent_insert_2 get]
		if { $insert_file_n == "" } {
			set insert_file_n "\n"
		}
	} else { set insert_file_n "\n"	}
	
	#Letter
	set insert_letter [$tm5.txt_insert_3 get 1.0 end]
	
	# End Page
	set end_code [$tm6.txt_end_code get 1.0 end]

	#Files
	set files [$tm7.slb get 0 end]
	#Delete the reference to the theme folder
	if { $files != "" && $files != "\n"  } {
		foreach file_name $files {
			regsub -all -nocase "$themes_folder" $file_name "" file_name
			append theme_files "$file_name\n"
		}
	} else { set theme_files "\n" }
	set path [$tm7.ent_path get]
	
	#Filters
	set filters [$tm0.ent_filter get]
	
	#Set the data of the theme
	set data "@name=$theme_name\n"
	append data "@section=User\n"
	append data "@desc=$theme_desc\n"
	append data "@start_code=$start_code"
	append data "@link_code=$link_code"
	append data "@struct_in_code=$struct_in_code"
	append data "@struct_out_code=$struct_out_code"
	append data "@level_1_code=$level_1_code"
	append data "@level_2_code=$level_2_code"
	append data "@level_3_code=$level_3_code"
	append data "@level_4_code=$level_4_code"
	append data "@insert_folder=$insert_folder"
	append data "@insert_folder_n=$insert_folder_n"
	append data "@insert_file=$insert_file"
	append data "@insert_file_n=$insert_file_n"
	append data "@insert_letter=$insert_letter"
	append data "@end_code=$end_code"
	append data "@files=$theme_files"
	append data "@path=$path\n"
	append data "@filters=$filters"	
	
	$page.txt_theme_desc delete 1.0 end
	$page.txt_theme_desc insert end "$data"
	
	#Write the theme file to a file. File name should be the name of the theme
	#	and it is stored in the folder called 'User'
	cd "$themes_folder/User"
	set out [open "$theme_name.thm" w]
	puts $out "$data"
	close $out
	
	tk_messageBox -message "Theme '$theme_name' saved to '$themes_folder/User/$theme_name.thm'"
}

##################################################################

# Function : toTitle
# This will take a string as argument and convert it to title case
# Arguments: A string 'str'
# Returns  : The titled version of 'str' called 'txt'
proc toTitle { str } {
	set parts [split $str { }]
	set txt ""
	for {set i 0} {$i < [llength $parts] } {incr i} {
		set t [lindex $parts $i]
		append txt "[string totitle $t] "
	}
	set txt [string trimright $txt]
	return $txt
}


################################## File Selction Page ##################################

# Function : itemCount
# This will count the number of items in the listbox, display it and return the number
proc itemCount { page } {
	set count [$page.slb size]
	$page.lbl_count configure -text "Item Count : $count"
	return count
}

# Function : saveList
# This will save the list to a local file of the users choice. The saving has a simple
# 		format - one file every line.
proc saveList { page } {
	global user_folder
	set files [$page.slb get 0 end]
	set data [join $files "\n"]
	
	#Get the file
	set types {
	{{List Files}       {.lst} }
	}
	set result [tk_getSaveFile -filetypes $types -defaultextension "lst" -initialdir $user_folder]
	
	if { $result != "" } {
		#Open the file
		set out [open $result w]
		#Write to the file
		puts $out $data
		flush $out
		close $out
	}
}

# Function : loadList
# This will get a list of files into the Scrolled List box. Each line in the file
# 		must have a file name in it.
proc loadList { page } {
	global user_folder
	#Get the file
	set types {
	{{List Files}       {.lst}       }
	{{Text Files}       {.txt}       }
	{{All Files}        *            }
	}

	set list_file [tk_getOpenFile -filetypes $types -initialdir $user_folder]
	
	if { $list_file != "" } {
		set in_file [open "$list_file" r]
		seek $in_file 0 start
		#Read the full content of the theme and get it line by line
		set content [read $in_file]
		#Closing the file
		close $in_file
		
		set files [split $content "\n"]
		foreach element $files {
			if { $element != "" } {
				$page.slb insert end $element
			}
		}
	}
	itemCount $page
}

# Function : deleteSelected
# Deletes all the selected files in the scrolllistbox and call for itemCount
# 		This works for 2 diffrent pages The add 'File Selection' page use this and 
# 		the 'Files' page in 'Manual' of 'Themes' use this too.
# Arguments : opt - Will be 1 for 'Files' Page and 0 for "File Selection' Page
proc deleteSelected { page opt } {
	set sels [$page.slb curselection]
	for {set i 0} {$i<[llength $sels]} {incr i} {
		set to_del [lindex $sels $i]
		#When an element is deleted, the index of all elements below it will decrease by 1
		#	So no of elements deleted must be subtacted from element index
		set to_del [expr $to_del - $i]
		$page.slb delete $to_del
	}
	
	#Works only for 'File Selection' Page
	if { $opt == 0 } {
		itemCount $page
	}
}

# Function : moveElement
# This will move an element in the ScrollListBox up or down accoding to the argument
# Argument : page and opt(1 or 0 - 0 for up and 1 for down) 
proc moveElement { page opt } {
	set sel [$page.slb curselection]
	#Get the content of the selection, Delete it, and move it to top 
	#	and then select it - one by one
	if { $opt == 0 } {
		#Up and down need 2 diffrent for loops because else, when the down command is given,
		#	only the first element will be moved because its index will keep changing
		for {set i 0} {$i<[llength $sel]} {incr i} {
			set no [lindex $sel $i]
			set item [$page.slb get $no]
			set move [expr $no - 1]	
			$page.slb delete $no
			$page.slb insert $move $item
			$page.slb selection set $move
		}
	} else {
		for {set i [expr [llength $sel] - 1]} {$i>=0} {set i [expr $i - 1]} {
			set no [lindex $sel $i]
			set item [$page.slb get $no]
			set move [expr $no + 1]	
			$page.slb delete $no
			$page.slb insert $move $item
			$page.slb selection set $move
		}
	}	
}

# Funciton : sorter
# This will sort the elements in the scolledlistbox in the specified order. I personally
# 		hate this function. The insert command would give a better order
proc sorter { page } {
	#Get the Chosen Sort Order
	set order [$page.om get]
	#Get the selections
	set sel [$page.slb curselection]	
	
	#Exit methord if none is selected
	if { $order == "None" } { return }
	
	#Sort according to folder
	if { $order == "Sort by Folder" } {
		set files [$page.slb get 0 end]	
		set base_folder [findCommonFolder $files]
		set base_length [string length $base_folder]
		lsort files
		$page.slb delete 0 end
		
		foreach i $files {
			set new_value [string range $i $base_length end]
			set parts [split $new_value "/"]
			set dirs [llength $parts]
			lappend new_order "$new_value $dirs"
		}

		#Sort the list according to the number of directories
		lsort -index 1 $new_order
		set i 0

		foreach value $new_order {
			#Must delete the folder number - So range from 0 to $value's end - 2
			set last [expr [llength $value] - 2]
			set file_name "$base_folder[lrange $value 0 $last]"
			#Insert the file intot correct position
			$page.slb insert $i $file_name
			incr i
		}
		
	} elseif { $sel <= 1 } {
	#If there is only one or no selection, sort the entire list
		$page.slb sort $order
	} else {
	#If there is a multiple selection, sort the selection and put it back
		for {set i 0} {$i<[llength $sel]} {incr i} {
			set no [lindex $sel $i]
			set item [$page.slb get $no]
			
			#Make new list of positions and order
			lappend pos $no
			lappend items $item
		}
		#Sort the list
		set items [lsort -$order $items]
		#Put them back in there places
		for {set i 0} {$i<[llength $pos]} {incr i} {
			set no [lindex $pos $i]
			set item [lindex $items $i]
			$page.slb delete $no
			$page.slb insert $no $item
			$page.slb selection set $no
		}
	}
}

# Function : filter
# This will let only specified kinds of a file to exist in the list. If the filter is
# 		set to *.*, every file will be indexed. If filter is *.txt;*.html only that
#		kind will enter
proc filter { page } {
	set all_filters [$page.ent_filter get]
	set files [$page.slb get 0 end]
	set filters [split $all_filters ";"]
	set allowed ""
	
	#Filter only if it is not '*.*'
	if {($all_filters != "*.*") && ($all_filters != "*") && ($all_filters != "") && ($all_filters != "\n") } {
		foreach i $files {
			#Get the extension of the current file
			set ext [file extension $i]
			foreach j $filters {
				#Get the extention for '*.ext' format
				set filers [split $j "."]
				if { [llength $filers] > 1 } {
					set fil ".[lindex $filers 1]"
				} else {
					set fil ".[lindex $filers 0]"
				}
				
				#If the extension is in the allowed list
				if { $ext == $fil } {
					lappend allowed $i
					break
				}
			}
		}
	
		#Clear the list and load new one - one by one
		$page.slb clear
		foreach element $allowed {
			$page.slb insert end $element
		}
		itemCount $page	
	}
}

# Function : addFile 
# Add Files to the List. Multiple files can be inputed. This works for 2 diffrent pages
# 		The add 'File Selection' page use this and the 'Files' page in 'Manual' 
# 		of 'Themes' use this too.
# Arguments : opt - Will be 1 for 'Files' Page and 0 for "File Selection' Page
proc addFile { page opt } {
	global start_folder theme_folder
	if { $opt } {
		set types {
		{{Script Files} 	{.js} 	      }
		{{Script Files} 	{.vbs}		  }
		{{Stylesheets} 		{.css}     	  }
		{{HTML Files}       {.html}       }
		{{HTML Files}       {.htm}        }		
		{{Picture Files}    {.gif}        }
		{{Picture Files}    {.jpg}        }
		{{Picture Files}    {.jpe}        }
		{{Picture Files}    {.bmp}        }
		{{Picture Files}    {.tga}        }
		{{Picture Files}    {.pix}        }
		{{Picture Files}    {.png}        }
		{{All Files}        *             }
		}
	} else {
		set types {
		{{All Files}        *             }
		{{Text Files}       {.txt}        }
		{{HTML Files}       {.html}       }
		{{HTML Files}       {.htm}        }
		{{Executable Files} {.exe}        }
		{{Executable Files} {.msi}        }
		{{Picture Files}    {.gif}        }
		{{Picture Files}    {.jpg}        }
		{{Picture Files}    {.jpe}        }
		{{Picture Files}    {.bmp}        }
		{{Picture Files}    {.tga}        }
		{{Picture Files}    {.pix}        }
		{{Picture Files}    {.png}        }
		{{Sound Files}      {.mid}        }
		{{Sound Files}      {.wav}        }
		}
	}

	#Opens the file chosing dialog
	set files [tk_getOpenFile -filetypes $types -multiple yes -initialdir $start_folder]

	if {$files != "" } {
	 	for {set i 0} {$i < [llength $files] } {incr i} {
		 	set insert "[lindex $files $i]"
			#See if there is a copy of the same file in the list, else insert it
			if {[lsearch -exact [$page.slb get 0 end] $insert] == -1} {
				$page.slb insert end "$insert"
	  		}
	  	}
	}
	
	#Only for the 'File Selection' Page
	if { !($opt) } {
		set filterer [$page.ent_filter get]
		#The Filtering	
		if { ($filterer != "*.*") && ($filterer != "*") } {
			filter $page
		} else { itemCount $page }
	}
}

# Function : addDir
# Get all files in a directory into the selection.  If a directory has other directories
# 	inside it, get all of them if that option is enabled by the user.
proc addDir {page} {
	#Get the options from the checkbox whether or not to list subfolders
	global mode start_folder
	set list_subfolders $mode

	#Opens the Directory chosing dialog.
	set folder [tk_chooseDirectory -mustexist yes -initialdir $start_folder]
	
	set total_folders 0
	#Get The Files
	if { $folder != "" } {
		#So that all dialog will start from this folder
		set start_folder $folder
		
		#Get file listing
		set files [lsort [glob -nocomplain [file join $folder .*] [file join $folder *]]]
		foreach i $files {
			if { $i != "$folder/." && $i != "$folder/.." } {
				if {[file isdirectory $i]} {
					#If the specifed file is a directory, add it to the list of
					#	directories of which's file listing we should get.
					lappend dirs $i
					incr total_folders
				} else {
					set insert "[file join $folder $i]"
					#See if there is a copy of the same file in the list, else insert it
					if {[lsearch -exact [$page.slb get 0 end] $insert] == -1} {
				  		$page.slb insert end "$insert"
			  		}
	  			}
	  		}
		}

		set flag 0
		#Continue indexing till all folders are done
		while { ($flag < $total_folders) && ($list_subfolders) } {
			#Get the name of the folder
			set folder [lindex $dirs $flag]
			#Get the list of files
			set files [lsort [glob -nocomplain [file join folder .*] [file join $folder *]]]
			foreach i $files {
				if { $i != "$folder/." && $i != "$folder/.." } {
					if {[file isdirectory $i]} {
						#If the specifed file is a directory, add it to the list of
						#	directories of which's file listing we should get.
						lappend dirs $i
						incr total_folders
					} else {						
						set insert "[file join $folder $i]"
						#See if there is a copy of the same file in the list, else insert it
						if {[lsearch -exact [$page.slb get 0 end] $insert] == -1} {
					  		$page.slb insert end "$insert"
				  		}
		  			}
			  	}
			}
			#Increment the folder number for the 'dirs' list
			incr flag
		}
	}
	#The Filtering
	set filterer [$page.ent_filter get] 
	if { ($filterer != "*.*") && ($filterer != "*") } {
		filter $page
	} else { itemCount $page }
}


################################## Result Page ##################################

# Function : findCommonFolder
# Find the common folder in the list of files given as argument. If the given files are 
# 		'C:\binny\life\history.txt' and C:\binny\stories\sf.txt', the returned folder
#		will be 'C:\binny\'
# Argument : files - The list of files of which common folder should be found
# Return   : <no name> - The common folder
proc findCommonFolder { files } {
	set first [lindex $files 0]
	#Start looking for common from the last folder (Full Folder Path)
	set s [string last "/" $first]

	set flag 1
	set fr [string range $first 0 $s]

	for { set i 0} {$i<[llength $files]} {incr i} {
		#Get the folder of the current file
		set this_range [string range "[lindex $files $i]" 0 $s]
		if { $fr == $this_range } {
			incr flag
		} else {
			set s [expr $s - 1]
			#If the directory is diffrent
			set flag 0
			#Get new directory position
			set s [string last "/" $first $s]
			set fr [string range $first 0 $s] 
			#Check this file again
			set i [expr $i - 1]
		}
	}
	return [string range $first 0 $s]
}

# Function : findResultFile
# Call a save dialog to save the result file and update the two entry field,
#		one with the file name and other with the folder
proc findResultFile { page } {
	global page1
	set types {
	{{HTML Files}       {.html}       }
	{{HTML Files}       {.htm}        }
	{{Text Files}       {.txt}        }
	{{All Files}        *             }
	}
	#Get the result file
	set folder [findCommonFolder [$page1.slb get 0 end]]

	set file_name "index.html"
	set result_file [tk_getSaveFile -filetypes $types -initialdir "$folder" -initialfile "$folder$file_name"]

	if { $result_file !="" } {
		#If there is no extension in the result_file add the string ".html" to 'result_file'
		set ext [file extension $result_file]
		if { $ext == "" } {
			append result_file ".html"
		}
		$page.ent_file delete 0 end
		$page.ent_file insert end "$result_file"

		#Get the title by takeing the name of the result file, or, if it is 'index'
		#		take the name of the containing folder instead
		set title [file tail $result_file]
		set title [file rootname $title]
		set diff  [string compare -nocase $title "index"]
		if {!$diff} {
			set title [file tail $folder]
		}
		set title [toTitle $title]
		$page.ent_title delete 0 end
		$page.ent_title insert 0 $title
	}
}

# Function : opener
# This will open the result file for viewing. It will call IE directly with the result
#		file as the argument. This will cause problems if IE is not there.
proc opener { page } {
	set html_file [$page.ent_file get]
	set res [ catch { 
		exec "C:/Program Files/Internet Explorer/IEXPLORE.EXE" "$html_file"
	} ]
	#Another option is 'exec "start" "$html_file"' - but it causes a lot of problems.
	if { $res } {
		tk_messageBox -message "Error : Can't open file '$html_file'." -icon error
	}
}

# Function : selectOne
# This is a local function, used by only by makeCode {}. This function takes three 
# 		arguments and returns the first that is not null
proc selectOne { txt variable_str default_str } {
	if { ($txt != "\n") && ($txt != "") } {
		set value $txt
	} elseif { $variable_str == "INVALID" } {
		set value ""
	} elseif { $variable_str != "" } {
		set value $variable_str
	} else {
		set value $default_str
	}
	return $value
}

# Function : alphaSort
# Sort the array in argument accoding to the filenames and return the resulting array
# Argument : arr - The array to be sorted. It is a list of filenames
# Return   : result - The sorted array
proc alphaSort { arr } {
	set result ""
	
	#Get just the filenames in an array
	foreach i $arr {
		set name [file tail $i]
		#To cancel the casing factor
		set name [string tolower $name]
		lappend names $name
	}
	#Sort the filename array
	set names [lsort $names]

	#Find the filename's position and put the paths in that position
	for {set i 0} {$i < [llength $names]} {incr i} {
		foreach fil $arr {
			set name [file tail $fil]
			#If the names of two array are the same
			if {![string compare -nocase $name [lindex $names $i]]} {
				#Solves the problem of multiple same filenames
				set res [lsearch -all -exact $result "$fil"]
				if { ($res != "") && ($res != -1) } {
				} else {
					lappend result $fil
					break
				}
			}
		}
	}
	return $result
}

# Function : findRelation
# This will find the relation between 2 files. Greatly needed for linking.
# Arguments: 	base - The file where the link will appear
#				target - The file to be linked
# Returns  : result - The relative link
proc findRelation { target base } {
	#The size and folders of the base file's path - Get just the folder path - no file name
 	set base_folders [split [file dirname $base] "/"]
 	set base_length [llength $base_folders]
 	#The size and folders of the target file's path
 	set target_folders [split [file dirname $target] "/"]
 	set target_length [llength $target_folders]

	#Get the lesser size number of '/' into 'length'. Done by spliting(done above) and 
	#		counting the parts
	if { $base_length >= $target_length } {
		set length $base_length
	} else {
		set length $target_length
	}

	#Initializations
	set slashes ""
	set slash_count $target_length
	
	#If base file's path and target file's are in the same drive
	if { [string index $base 0] == [string index $target 0] } {
		for { set i 0 } { $i < $length } { incr i } {
			#If the corresponding folders of both strings are same, we don't need that 
			#	folder, so 1 '/' is avoided - thus $slash_count--
			if { [lindex $base_folders $i] == [lindex $target_folders $i] } {
				set slash_count [expr $slash_count - 1]
			}
		}

	#How many '../'s? 
	#	Number of not same folders - (Total folders in target - Total folders in base)
	set diff [expr $target_length - $base_length ]
	set slashs [expr $slash_count - $diff]

	#Put a '../' for every different directory.
	for { set j 0 } { $j < $slashs } { incr j } { append slashes "../" }

	#Get all elements from '$slash_count' to the end and join them with a '/'
	set file_path [join [lrange $target_folders [expr $target_length - $slash_count] end] "/"]
	#Get the final result by combining the '../'s and remaining string
	set result "$slashes$file_path/[file tail $target]"
	
	} else {
		#If the 2 files are in diffrent drives, absolute links are nessary
		set result $target
	}
	
	#If both files are in same directory, a '/' will be there. Remove it
	if { [string index $result 0] == "/" } {
		set result [string range $result 1 end]
	}

	#Returning the result
	return $result
}

# Function : makeCode
# Convert all the files in the 'Selected' Listbox to html code with relative
#		path. This function also but the result into the code textarea.
#		Should implement the theme functions
proc makeCode {page} {
	#Get the name of the first page
	global page1 case_fixing version
	#Get all manual pages
	global tm1 tm2 tm3 tm4 tm5 tm6
	#Get the name of all variables where theme data is stored
	global start_code link_code struct_in_code struct_out_code
	global level_1_code level_2_code level_3_code level_4_code
	global insert_folder insert_folder_n insert_file insert_file_n insert_letter
	global end_code filters

	#Initializations
	set file_count 0
	set folder_count 0
	set level_code ""
	set last_alpha ""
	set current_content ""
	set alpha ""
	set unfinished_folders_count 0
	set unfinished_folders ""
	set folder_open 0
	
	#Get date and time
	set seconds [clock seconds]
	set current_time [clock format $seconds -format "%I:%m %p"]
	set date [clock format $seconds -format "%e %B, %Y"]
	
	#Get the list of the selected files in the List Box after filtering it
	$page1.ent_filter delete 0 end
	#If no filters are specifed, make it *.*
	if { $filters == "" || $filters == "\n" } {
		$page1.ent_filter insert end "*.*"
	} else {
		$page1.ent_filter insert end "$filters"
	}
	filter $page1
	#Getting the files
	set files [$page1.slb get 0 end]
	
	# Get the file to save to, get its folder name and change to that folder
	set result_file [$page.ent_file get]
	set folder [file dirname $result_file]
	set base_folder [findCommonFolder $files]

	#If there no result file is set, generate an error message.
	if { $result_file == "" } {
		tk_messageBox -message "Please chose a result file." -type "ok" -icon "info"
		return
	}

	#Get the title
	set title [$page.ent_title get]
	
	#Call the function that copies the theme sturcture to the variables
	defaulter 1
	defaulter 2
	defaulter 3
	defaulter 4
	defaulter 5
	defaulter 6
		
	#HTML Text - Get all the variables
	set start [selectOne [$tm1.txt_start_code get 1.0 end] $start_code "<HTML><HEAD>\n<TITLE>%Title%</TITLE>\n<STYLE>\n<!--\nA { COLOR:blue; TEXT-DECORATION:none; }\nA:hover { COLOR:red;}\n// -->\n</STYLE>\n</HEAD>\n<BODY>\n<H1>%Title%</H1>\n"]
	set linking [selectOne [$tm2.txt_link_code get 1.0 end] $link_code "<A HREF=\"%LINK%\">%FILE_NAME%</A><BR>\n"]
	set in_folder [selectOne [$tm3.txt_structure_1 get 1.0 end] $struct_in_code "\n%Level_code%\n"]
	set out_folder [selectOne [$tm3.txt_structure_2 get 1.0 end] $struct_out_code ""]
	#Levels
	set level_1 [selectOne [$tm4.txt_level_1 get 1.0 end] $level_1_code "<H3>%folder_name%</H3>"]
	set level_2 [selectOne [$tm4.txt_level_2 get 1.0 end] $level_2_code "<H4>%folder_name%</H4>"]
	set level_3 [selectOne [$tm4.txt_level_3 get 1.0 end] $level_3_code "<BR><B>%folder_name%</B><BR>"]
	set level_4 [selectOne [$tm4.txt_level_4 get 1.0 end] $level_4_code "<BR><I>%folder_name%</I><BR>"]

	#Insersions
	set per_folder [selectOne [$tm5.txt_insert_1 get 1.0 end] $insert_folder ""]
	#Asking a disabled item for content with 'cget' is asking for error.
	set state [$tm5.ent_insert_1 cget -state]
	set per_folder_n [selectOne [$tm5.ent_insert_1 get] $insert_folder_n 0]

	set per_file [selectOne [$tm5.txt_insert_2 get 1.0 end] $insert_file ""]
	set state [$tm5.ent_insert_2 cget -state]
	set per_file_n [selectOne [$tm5.ent_insert_2 get] $insert_file_n 0]

	set per_letter [selectOne [$tm5.txt_insert_3 get 1.0 end] $insert_letter ""]	
	# End Page
	set ending [selectOne [$tm6.txt_end_code get 1.0 end] $end_code "</BODY></HTML>\n"]

	#If Alphabetic setting is on
	if {$per_letter!=""} {
		#Sort the files by the filenames
		set files [alphaSort $files]
	}

	#Beginning the HTML Code
	set content $start
	
	set my_notice "\n<P ALIGN=right>Made with Indexer V$version from <A HREF=\"http://www.geocities.com/binnyva\">Binny's Softwares</A>.</P>\n"
	
	#Going thru every file to link it
 	#Temporary setting. Other wise program will show error.
 	set last_folder_name "x"
 	set last_folder "x"
 	set last_depth 0

	for {set i 0} {$i < [llength $files]} {incr i} {
		set current_content ""
		#Get a filename from the list
		set txt [lindex $files $i]

		#Make it the link relative by calling 'findRelation' methord
		set link [findRelation $txt $result_file]
		
		#Get just the filename out - with out the directory and the extension
		set name [file tail $txt]
		set name [file rootname $name]

		set extension [file extension $txt]
		set extension [string range $extension 1 end]

		#Find the number of '/'s in the filename so that directory depth can be found
		#Find relation from the Base folder for better results
		set temp  [findRelation $txt "$base_folder/Somthing.txt"]
		set arr   [split $temp "/"]
		#If there is a '..' don't count it as depth
		set depth -1
		foreach element $arr {
			if { $element != ".." } { incr depth }
		}

		#Get the containing folder's name
		set folder_name [file dirname $txt]
		set full_folder_path $folder_name
		set folder_name [file tail $folder_name]
		#Make all wanted things to title case
		if { $case_fixing } {
			set folder_name_title [toTitle $folder_name]
			set name [toTitle $name]
		} else {
			set folder_name_title $folder_name
		}

		#Going into a new folder for the first time
		if {([string compare $folder_name $last_folder_name]) && \
				 ([string compare -nocase $folder_name $title])  && \
				 ([string compare -nocase $folder_name [file tail $folder]])} {
			#Give headings according to folder depth
			switch -- $depth {
				0		{ }
				1		{ set level_code "$level_1" }
				2		{ set level_code "$level_2" }
				3 		{ set level_code "$level_3" }
				default { set level_code "$level_4" }
	   		}
	   		#Replacing %%'s
	   		regsub -all -nocase "\%Last_Folder_Name\%" $level_code "$last_folder" level_code
			regsub -all -nocase "\%full_folder_path\%" $level_code "$full_folder_path" level_code
			regsub -all -nocase "\%folder_name\%" $level_code "$folder_name_title" level_code
   		}

   		#Enter if still in same folder
		if {!([string compare $folder_name $last_folder_name])} {
			#Counting Files
			incr file_count

			#Insert things that has to be inserted every 'n' files
			if { ([string is digit $per_file_n]) && ($per_file_n!=0) } {
				if { [expr $file_count % $per_file_n] == 0 } {
					append current_content $per_file
				}
			}
		} else {
			#This will happen every time new folder is found

#### See "Explanation 1. Folder In/Out Structure" for more info about the code under this
####	line
			#Check if any folder is finished
			for {set k 0} {$k<[llength $unfinished_folders]} { incr k } {
				#If the unfinished folder is not found in the current path
				set element [lindex $unfinished_folders $k]
				set check [string first $element $full_folder_path]
				if {($check < 0) && ($element != "***") } {
					append current_content "$out_folder"
					#Disable this entry
					lset unfinished_folders $k "***"
					#Because this is a finished folder, 
					set unfinished_folders_count [expr $unfinished_folders_count - 1]
				}
			}

			#This will happen every time a new folder is found, execpt for the root
			if { ($folder != [file dirname $txt]) || ($folder_count) } {
				#Write Structure - Going OUT of a SubFolder
				if { $depth <= $last_depth } {
					append current_content "$out_folder"
					set folder_open 0
				} else {
					incr unfinished_folders_count
					#Get containing folder so that we know what the unfinished folder is
					set fold [file dirname $full_folder_path]
					lappend unfinished_folders "$fold/"
				}

				#Write Structure - Going into a SubFolder
				regsub -all -nocase "\%level_code\%" $in_folder "$level_code" to_write
				append current_content "$to_write"

				set folder_open 1
			}

			#Insert things that has to be inserted every 'n' folders
			if {([string is digit $per_folder_n])&&($per_folder_n!=0)&&($folder_count>0)} {
				if  {[expr $folder_count % $per_folder_n] == 0 } {
					append current_content $per_folder
				}
			}

			#Reset the filecounter because we are in a new folder
			set file_count 0
			#Increase the folder count
			incr folder_count
			
			set last_depth $depth
		}

		#Writing accoding to the Alpabetic order
		if { ($per_letter!="") && ($per_letter!="\n") } {
			#Get the first letter of current file name
			set alpha [string index $name 0]

			#If we encountered a new charecter for the first time
			if { $last_alpha != $alpha } {
				regsub -all -nocase "\%letter\%" $per_letter "$alpha" to_write
				append current_content $to_write
			}

			set last_alpha $alpha
		}

   		#Writing HTML
		append current_content "$linking"
		
		#Replacing %%'s
		#See if there is a '&' in the link. This messes with the regular expression result.
		if { [string match "*&*" $txt]  } { set txt [changeChar $txt "&" "\\\&"] }
 		if { [string match "*&*" $link] } { set link [changeChar $link "&" "\\\&"]	}
 		if { [string match "*&*" $name] } { set name [changeChar $name "&" "\\\&"]	}
 		if { [string match "*&*" $folder_name_title] } { set folder_name_title [changeChar $folder_name_title "&" "\\\&"] }
 		if { [string match "*&*" $full_folder_path] } { set full_folder_path [changeChar $full_folder_path "&" "\\\&"]	}

		regsub -all -nocase "\%link\%" $current_content "$link" current_content
		regsub -all -nocase "\%file_name\%" $current_content "$name" current_content
		regsub -all -nocase "\%full_name\%" $current_content "$txt" current_content
		regsub -all -nocase "\%full_folder_path\%" $current_content "$full_folder_path" current_content
		regsub -all -nocase "\%folder_name\%" $current_content "$folder_name_title" current_content
		regsub -all -nocase "\%last_folder_name\%" $current_content "$last_folder" current_content
		regsub -all -nocase "\%extention\%" $current_content "$extension" current_content
		regsub -all -nocase "\%file_number\%" $current_content "$i" current_content

		#Set the last folder so that a new folder can be identified
	   	set last_folder_name $folder_name
	   	set last_folder $folder_name_title
	   	
	   	append content $current_content
	}
	
	#HTML Text - End
	#A last Structure for going out of a folder is needed
	if {$folder_open} { append content "$out_folder" }
	for {set k 0} {$k < $unfinished_folders_count} {incr k} {
		append content "$out_folder"
	}
	
	#The End
	regsub -all -nocase "</body>" $ending "$my_notice</body>" ending
	append content "$ending"

	#Replace the %%'s
	regsub -all -nocase "\%time\%" $content "$current_time" content
	regsub -all -nocase "\%date\%" $content "$date" content
	regsub -all -nocase "\%title\%" $content "$title" content
	regsub -all -nocase "\%page_title\%" $content "$title" content
	regsub -all -nocase "\%main_folder_path\%" $content "$folder" content
	regsub -all -nocase "\%main_folder_name\%" $content "[file tail $folder]" content
	regsub -all -nocase "\%no_of_files\%" $content "[llength $files]" content
	
	#See if there were any files to index - Some users want the result without 
	#		adding any file
	if { $i != 0 } {
		#Write to screen
	 	$page.txt_code delete 1.0 end
	 	$page.txt_code insert end "$content"
	
		#Enable the disabled Save Button
		$page.but_save_file configure -state normal
	
		#Ask the user if he want to save the file
	 	set answer [tk_messageBox -message "Save the file to \"$result_file\"?" -type yesno -icon question]
	 	if { $answer == yes} {
	 		saveResult $page
	 	}
	} else {
		tk_messageBox -message "No files were selected. Please select some files in the 'File Selection' page." -icon error
	}
}

# Function : saveResult
# This methord will save the result in the code area to the specified file
proc saveResult { page } {
	global tm7 themes_folder
	#Get the file name and the code
	set result_file [$page.ent_file get]
	set dir [file dirname $result_file]
	set code [$page.txt_code get 1.0 end]
	set folder "$dir"
	
	#Open the file
	set out [open $result_file w]
	#Write to the file
	puts $out $code
	flush $out
	close $out
	
	#Call the function that sets the files and paths
	defaulter 7
	set files [$tm7.slb get 0 end]
	set path [$tm7.ent_path get]

	#Make the folder
	if {$path != "" || $path != "\n"} {
		set folder "$dir/$path"
		if { ![file exists $folder] } {
			file mkdir "$folder"
		}
	}
	#Copy files 1 by 1
	foreach part $files {
		set file_name "$part"
		if {[file exists $file_name]} {
			if {[file isdirectory  "$folder"]} {
				#See if the file exist.
				set name [file tail "$file_name"]
				if { [file exists "$folder/$name"] } {
					#Ask user if he want's to overwrite
					if { [tk_messageBox -message "A file called '$folder/$name' already exists. Overwrite?" -icon question -type yesno] } {
						file copy -force "$file_name" "$folder"
					}
				} else {
					file copy "$file_name" "$folder"
				}
			}
		} else {
			tk_messageBox -message "A file called \"$file_name\" don't exist. Make sure that it is specifed correctly." -icon warning
		}
	}
	
	#Enable the Open in Browser button
	$page.but_open configure -state normal
}

##########################################################################################
#GUI Programming
##########################################################################################

package require Iwidgets 4.0
set heading "-Adobe-Helvetica-Bold-R-Normal--*-150-*-*-*-*-*-*"
set editing "-Adobe-Courier-*-R-Normal--*-130-*-*-*-*-*-*"

option add *Tabnotebook.backdrop DimGray
iwidgets::tabnotebook .tnb -width 5.5i -height 4.5i -background Gray -borderwidth 0
pack .tnb

# ----------------------------------------------------------------------
# Page #1 - File Selction
# ----------------------------------------------------------------------
set page [.tnb add -label "File Selction"]
set page1 $page

label $page.lbl_main -text {File Selction} -font $heading
#List Box
frame $page.frm_slb
iwidgets::scrolledlistbox $page.slb -labeltext "Selected Files" -labelpos nw \
    -vscrollmode dynamic -hscrollmode none -selectmode multiple
button $page.but_slb_up   -text {^} -command "moveElement $page 0"
button $page.but_slb_down -text {v} -command "moveElement $page 1"

#File Seclection part
frame $page.frm_down_buts
#Fill Adding Buttons
frame $page.frm_adder -borderwidth 1 -relief sunken
button $page.but_add_file   -command "addFile $page 0" -text {Add File}
button $page.but_add_folder -command "addDir  $page" -text {Add Folder}
checkbutton $page.ckbut_subfolder -text {Select files in Subfolders} -variable mode
$page.ckbut_subfolder select

#List Controller Buttons
button $page.but_clear_list -command "$page.slb delete 0 end\nitemCount $page" -text {Clear List}
label $page.lbl_count -text {Item Count : 0}

frame $page.frm_downers
#Filter
frame $page.frm_filter -bd 1 -relief sunken
label $page.lbl_filter -text "Filter for 'Add Folder' operation"
entry $page.ent_filter
$page.ent_filter insert end "*.*"
button $page.but_filter -text "Filter Now" -command "filter $page"

#Sort Options.  "Sort by Folder" option is taken out
iwidgets::optionmenu $page.om -labeltext "Sort Order" -command "sorter $page"
$page.om insert end None increasing decreasing
#Delete Button
button $page.but_del_file -command "deleteSelected $page 0" -text {Delete Selected Files}

frame $page.frm_rock_bottom
button $page.but_save_list -text {Save Current List} -command "saveList $page"
button $page.but_load_list -text {Load List} -command "loadList $page"

#Geometry Management
set padding 40
grid $page.lbl_main -in $page -row 1 -column 1
#The Listbox
grid $page.frm_slb      -in $page -row 2 -column 1 -sticky we -pady 15
grid $page.slb          -in $page.frm_slb -row 1 -column 1 -sticky we -rowspan 2
grid $page.but_slb_up   -in $page.frm_slb -row 1 -column 2 -padx 2
grid $page.but_slb_down -in $page.frm_slb -row 2 -column 2 -padx 2

grid $page.frm_down_buts      -in $page -row 3 -column 1 -sticky we -pady 2
#Adding File to 'Available'
grid $page.frm_adder       -in $page.frm_down_buts -row 1 -column 1 -padx $padding
grid $page.but_add_file    -in $page.frm_adder -row 1 -column 1 -padx 2
grid $page.but_add_folder  -in $page.frm_adder -row 1 -column 2
grid $page.ckbut_subfolder -in $page.frm_adder -row 1 -column 3 -padx 10
#List Controller Options
grid $page.but_clear_list -in $page.frm_down_buts -row 1 -column 2 -padx 10
grid $page.lbl_count      -in $page.frm_down_buts -row 1 -column 3 -padx 5

grid $page.frm_downers    -in $page.frm_down_buts -row 2 -column 1 -columnspan 3
#Filter
grid $page.frm_filter -in $page.frm_downers -row 1 -column 1 -sticky w -ipadx 3 -ipady 3 -pady 15
grid $page.lbl_filter -in $page.frm_filter  -row 1 -column 1
grid $page.ent_filter -in $page.frm_filter  -row 1 -column 2
grid $page.but_filter -in $page.frm_filter  -row 1 -column 3 -padx 15
#List Controller
grid $page.om             -in $page.frm_downers -row 2 -column 1
grid $page.but_del_file   -in $page.frm_downers -row 2 -column 2

grid $page.frm_rock_bottom -in $page -row 4 -column 1 -pady 10 -sticky w
grid $page.but_save_list   -in $page.frm_rock_bottom -row 1 -column 1 -padx 10
grid $page.but_load_list   -in $page.frm_rock_bottom -row 1 -column 2 -padx 10

grid columnconfigure $page 1 -weight 0 -minsize 500
grid columnconfigure $page.frm_slb 1 -weight 0 -minsize 475

# ----------------------------------------------------------------------
# Page #2
# ----------------------------------------------------------------------
set page [.tnb add -label "Themes"]
set page2 $page

iwidgets::tabnotebook $page.tnb_themes -background Gray -backdrop White \
		-borderwidth 0 -tabpos s -angle 0
pack $page.tnb_themes -in $page -fill both -expand yes

# ----------------------------------------------------------------------
# The Theme Pages(tp) Page 1
set tp [$page.tnb_themes add -label "Themes"]
set tp1 $tp

##########
# Themes #
##########

#Load the themes from the themes folder
loadThemes $tp

label $tp.lbl_heading -text {Themes Library} -font $heading
frame $tp.frm_themes -bd 2 -relief raised
frame $tp.frm_names
#The two listboxes
label $tp.lbl_catogory -text {Categories}
iwidgets::scrolledlistbox $tp.slb_l -selectioncommand "themeFinder $tp"
label $tp.lbl_themes -text {Themes}
iwidgets::scrolledlistbox $tp.slb_r -selectioncommand "themeInfo $tp"
#Filling the listboxes
populateSections $tp

#This button will clear the listboxes and load the themes again
button $tp.but_refresh -text {Refresh Themes} -command "refreshThemes $tp"

frame $tp.frm_details -relief raised -bd 1
label $tp.lbl_details_heading -text {Theme Information}
iwidgets::scrolledtext $tp.txt_details -height 200 -width 200

#Geomatry
grid $tp.lbl_heading -in $tp -row 1 -column 1 -columnspan 2

grid $tp.frm_themes -in $tp -row 2 -column 1 -pady 30 -ipady 15 -ipadx 5
grid $tp.frm_names -in $tp.frm_themes -row 2 -column 1 -sticky n -padx 5

grid $tp.lbl_catogory -in $tp.frm_names -row 1 -column 1 -sticky s
grid $tp.lbl_themes   -in $tp.frm_names -row 1 -column 2 -sticky s

grid $tp.slb_l -in $tp.frm_names -row 2 -column 1 -sticky n
grid $tp.slb_r -in $tp.frm_names -row 2 -column 2 -sticky n

grid $tp.but_refresh  -in $tp.frm_names -row 3 -column 1 -columnspan 2 -sticky s -pady 10

grid $tp.frm_details -in $tp.frm_themes -row 2 -column 2 -sticky ns -padx 10
grid $tp.lbl_details_heading -in $tp.frm_details -row 1 -column 1 
grid $tp.txt_details         -in $tp.frm_details -row 2 -column 1 -sticky ew


#####################################################################

# ----------------------------------------------------------------------
# The Theme Pages(tp) Page 2
set tp [$page.tnb_themes add -label "Manual" -command "defaulter 0"]
set tp2 $tp
#########################
# Manual Theme Settings #
#########################

iwidgets::tabnotebook $tp.tnb_manual \
	-background Gray -backdrop Gray -tabbackground Gray -tabforeground #555555 \
	-borderwidth 0 -width 5.1i -height 4i -equaltabs false \
	-bevelamount 1 -tabpos n -angle 0 -margin 0
pack $tp.tnb_manual -in $tp -fill both -expand yes

# _______________________________________________________________________
# The Theme Manual Pages(tm) Page 0
set tm [$tp.tnb_manual add -label "Introduction"]
set tm0 $tm
# This page is made so that the user will have to click on the other tabs, triggering the 
#		'defaulter' function

label $tm.lbl_intro_heading -text "$theme_name" -font $heading
frame $tm.frm_intro -bd 1 -relief ridge

label $tm.lbl_theme_intro -wraplength 500 -justify "left" \
	-text "Manual Settings for $theme_name.\n$theme_desc"

label $tm.lbl_intro -wraplength 500 -justify "left" \
	-text {
You can use Manual Settings function if you want to create themes of your own or make \
changes to the existing themes. The features are self-explanatory. For example, clicking \
the 'Start' tab will give a text area in which you have to enter the \
text that appears at the start of the resulting HTML file. Similerly, the 'Link' tab will \
give the code that will appear when a file is linked.

The 'Insert' feature is very useful. You can insert the code that will change every time.
For example, if the code '<A HREF="%LINK%">%FILE_NAME%</A>' is given in the link tab, \
the program will replace the '%LINK%' with the relative link to the file and replace \
'%FILE_NAME%' with the name of the linked file.

Any user with a decent knowledge of HTML can make intricate indexes using this software.
}

#Filters
frame $tm.frm_filter -relief sunken -bd 1
label $tm.lbl_filter -text {Theme Filters} -font $heading
entry $tm.ent_filter
label $tm.lbl_filter_desc -text {Only these files will be indexed for this theme.}

#Geomatry Management
grid $tm.lbl_intro_heading -in $tm -row 1 -column 1 -sticky n -pady 5
grid $tm.frm_intro -in $tm -row 2 -column 1 -sticky ew
grid $tm.lbl_theme_intro -in $tm.frm_intro -row 1 -column 1 -sticky w
grid $tm.lbl_intro -in $tm.frm_intro -row 2 -column 1 -sticky w

grid $tm.frm_filter -in $tm -row 3 -column 1 -sticky s -ipadx 2 -ipady 2 -pady 5
grid $tm.lbl_filter -in $tm.frm_filter -row 1 -column 1
grid $tm.ent_filter -in $tm.frm_filter -row 1 -column 2 -padx 10
grid $tm.lbl_filter_desc -in $tm.frm_filter -row 1 -column 3 -padx 1

# _______________________________________________________________________
# The Theme Manual Pages(tm) Page 1
set tm [$tp.tnb_manual add -label "Start" -command "defaulter 1"]
set tm1 $tm

frame $tm.frm_start
label $tm.lbl_start -text {Page Start} -font $heading
iwidgets::optionmenu $tm.om_inserts -labeltext "Insert Codes :" -labelpos w -command "insertCode $tm txt_start_code om_inserts"
$tm.om_inserts insert end "Insert" "Page_Title" "Main_Folder_Path" "Main_Folder_Name" "No_of_Files" "Date" "Time"
iwidgets::scrolledtext $tm.txt_start_code -height 290 -width 5i -textfont $editing \
	 -wrap none -vscrollmode dynamic  -hscrollmode dynamic

grid $tm.frm_start  -in $tm -row 1 -column 1 -sticky n
grid $tm.lbl_start  -in $tm.frm_start -row 1 -column 1 -sticky w
grid $tm.om_inserts -in $tm.frm_start -row 1 -column 2 -sticky e
grid $tm.txt_start_code -in $tm.frm_start -row 2 -column 1 -columnspan 2 -sticky ew

# _______________________________________________________________________
# The Theme Manual Pages(tm) Page 2
set tm [$tp.tnb_manual add -label "Links" -command "defaulter 2"]
set tm2 $tm

frame $tm.frm_link
label $tm.lbl_link -text {Linking Code} -font $heading
iwidgets::optionmenu $tm.om_inserts_lnk -labeltext "Insert Codes :" -labelpos w -command "insertCode $tm txt_link_code om_inserts_lnk"
$tm.om_inserts_lnk insert end "Insert" "Link" "File_Name" "Full_Name" "Full_Folder_Path" "Folder_Name" "File_Number" "Page_Title" "Extention"
iwidgets::scrolledtext $tm.txt_link_code -height 290 -width 5i  -textfont $editing \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic

grid $tm.frm_link       -in $tm -row 1 -column 1 -sticky n
grid $tm.lbl_link       -in $tm.frm_link -row 1 -column 1 -sticky w
grid $tm.om_inserts_lnk -in $tm.frm_link -row 1 -column 2 -sticky e
grid $tm.txt_link_code  -in $tm.frm_link -row 2 -column 1 -columnspan 2 -sticky ew

# _______________________________________________________________________
# The Theme Manual Pages(tm) Page 3
set tm [$tp.tnb_manual add -label "Structure" -command "defaulter 3"]
set tm3 $tm

frame $tm.frm_structure
label $tm.lbl_structure -text {Going into a Subfolder} -font $heading
iwidgets::optionmenu $tm.om_inserts_struct1 -labeltext "Insert Codes :" -labelpos w -command "insertCode $tm txt_structure_1 om_inserts_struct1"
$tm.om_inserts_struct1 insert end "Insert" "Level_Code" "Folder_Name" "Full_Folder_Path" "Page_Title"
iwidgets::scrolledtext $tm.txt_structure_1 -height 130 -width 5i -textfont $editing \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic

label $tm.lbl_structure_2 -text {Going out of a Subfolder} -font $heading
iwidgets::optionmenu $tm.om_inserts_struct2 -labeltext "Insert Codes :" -labelpos w -command "insertCode $tm txt_structure_2 om_inserts_struct2"
$tm.om_inserts_struct2 insert end "Insert" "Full_Folder_Path" "Folder_Name" "Page_Title"
iwidgets::scrolledtext $tm.txt_structure_2 -height 130 -width 5i -textfont $editing \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic

grid $tm.frm_structure      -in $tm -row 1 -column 1 -sticky n
grid $tm.lbl_structure      -in $tm.frm_structure -row 1 -column 1 -sticky w
grid $tm.om_inserts_struct1 -in $tm.frm_structure -row 1 -column 2 -sticky e
grid $tm.txt_structure_1    -in $tm.frm_structure -row 2 -column 1 -columnspan 2 -sticky ew
grid $tm.lbl_structure_2    -in $tm.frm_structure -row 3 -column 1 -sticky w
grid $tm.om_inserts_struct2 -in $tm.frm_structure -row 3 -column 2 -sticky e
grid $tm.txt_structure_2    -in $tm.frm_structure -row 4 -column 1 -columnspan 2 -sticky ew

# _______________________________________________________________________
# The Theme Manual Pages(tm) Page 4
set tm [$tp.tnb_manual add -label "Levels" -command "defaulter 4"]
set tm4 $tm

frame $tm.frm_levels
label $tm.lbl_editint_level -text {Editing} -font "$heading"

#This selects which text area the inserted code should go to.
frame $tm.rb
radiobutton $tm.rb.level1 -text "1" -variable insert_into -value txt_level_1
$tm.rb.level1 select
radiobutton $tm.rb.level2 -text "2" -variable insert_into -value txt_level_2
radiobutton $tm.rb.level3 -text "3" -variable insert_into -value txt_level_3
radiobutton $tm.rb.level4 -text "4" -variable insert_into -value txt_level_4

label $tm.lbl_level_1 -text {Level 1} -font "$heading"
iwidgets::scrolledtext $tm.txt_level_1 -height 50 -width 3i \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic

label $tm.lbl_level_2 -text {Level 2} -font "$heading"
iwidgets::scrolledtext $tm.txt_level_2 -height 50 -width 3i \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic

label $tm.lbl_level_3 -text {Level 3} -font "$heading"
iwidgets::scrolledtext $tm.txt_level_3 -height 50 -width 3i \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic

label $tm.lbl_level_4 -text {Level 4} -font "$heading"
iwidgets::scrolledtext $tm.txt_level_4 -height 50 -width 3i \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic

iwidgets::optionmenu $tm.om_inserts_level -labelpos n -labeltext "Insert:" \
	-command "insertCode $tm invalid om_inserts_level"
$tm.om_inserts_level insert end "Insert" "Full_Folder_Path" "Folder_Name" "Page_Title"

#Geometry Management
grid $tm.frm_levels        -in $tm -row 1 -column 1 -sticky n
grid $tm.lbl_editint_level -in $tm.frm_levels -row 1 -column 1 -columnspan 2 -sticky w
grid $tm.om_inserts_level  -in $tm.frm_levels -row 2 -column 3 -rowspan 8 -sticky e
grid $tm.rb        -in $tm.frm_levels -row 2 -column 1 -rowspan 8 -sticky ns
grid $tm.rb.level1 -in $tm.rb -row 1 -column 1 -pady 25
grid $tm.rb.level2 -in $tm.rb -row 2 -column 1 -pady 25
grid $tm.rb.level3 -in $tm.rb -row 3 -column 1 -pady 25
grid $tm.rb.level4 -in $tm.rb -row 4 -column 1 -pady 25

grid $tm.lbl_level_1 -in $tm.frm_levels -row 2 -column 2 -sticky w
grid $tm.txt_level_1 -in $tm.frm_levels -row 3 -column 2

grid $tm.lbl_level_2 -in $tm.frm_levels -row 4 -column 2 -sticky w
grid $tm.txt_level_2 -in $tm.frm_levels -row 5 -column 2

grid $tm.lbl_level_3 -in $tm.frm_levels -row 6 -column 2 -sticky w
grid $tm.txt_level_3 -in $tm.frm_levels -row 7 -column 2

grid $tm.lbl_level_4 -in $tm.frm_levels -row 8 -column 2 -sticky w
grid $tm.txt_level_4 -in $tm.frm_levels -row 9 -column 2


# _______________________________________________________________________
# The Theme Manual Pages(tm) Page 5
set tm [$tp.tnb_manual add -label "Insertions" -command "defaulter 5"]
set tm5 $tm

set insert_height 90
frame $tm.frm_inserts

#This selects which text area the inserted code should go to.
frame $tm.rbs
radiobutton $tm.rbs.insert1 -text "1" -variable insert_into -value txt_insert_1
$tm.rbs.insert1 select
radiobutton $tm.rbs.insert2 -text "2" -variable insert_into -value txt_insert_2
radiobutton $tm.rbs.insert3 -text "3" -variable insert_into -value txt_insert_3

label $tm.lbl_insert_1 -text "Every n\'th Folder" -font $heading
iwidgets::scrolledtext $tm.txt_insert_1 -height $insert_height -width 3i \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic -textfont $editing
label $tm.lbl_insert_n_1 -text {N:}
entry $tm.ent_insert_1 -width 2
button $tm.but_insert_1 -text {Activate} \
	-command "$tm.ent_insert_1 configure -state normal\n$tm.txt_insert_1 configure -state normal\n$tm.rbs.insert1 configure -state normal"

label $tm.lbl_insert_2 -text "Every n\'th File" -font $heading
iwidgets::scrolledtext $tm.txt_insert_2 -height $insert_height -width 3i \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic -textfont $editing
label $tm.lbl_insert_n_2 -text {N:}
entry $tm.ent_insert_2 -width 2
button $tm.but_insert_2 -text {Activate} \
	-command "$tm.ent_insert_2 configure -state normal\n$tm.txt_insert_2 configure -state normal\n$tm.rbs.insert2 configure -state normal"

label $tm.lbl_insert_3 -text {At New Letters} -font $heading
iwidgets::scrolledtext $tm.txt_insert_3 -height $insert_height -width 3i \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic -textfont $editing
button $tm.but_insert_3 -text {Activate} \
	-command "$tm.txt_insert_3 configure -state normal\n$tm.rbs.insert3 configure -state normal"

iwidgets::optionmenu $tm.om_inserts_insert -labelpos w -labeltext "Insert:" \
	-command "insertCode $tm invalid om_inserts_insert"
$tm.om_inserts_insert insert end "Insert" "Full_Folder_Path" "Folder_Name" "Last_Folder" "Page_Title" "Letter"

#Geometry Management
grid $tm.frm_inserts        -in $tm -row 1 -column 1 -sticky n
grid $tm.om_inserts_insert  -in $tm.frm_inserts -row 1 -column 2 -sticky e

grid $tm.rbs        -in $tm.frm_inserts -row 2 -column 1 -rowspan 8 -sticky ns
grid $tm.rbs.insert1 -in $tm.rbs -row 1 -column 1 -pady 35
grid $tm.rbs.insert2 -in $tm.rbs -row 2 -column 1 -pady 35
grid $tm.rbs.insert3 -in $tm.rbs -row 3 -column 1 -pady 35


grid $tm.lbl_insert_1  -in $tm.frm_inserts -row 2 -column 3 -columnspan 3 -sticky w -pady 10
grid $tm.txt_insert_1  -in $tm.frm_inserts -row 2 -column 2 -padx 10 -rowspan 2 -pady 5
grid $tm.lbl_insert_n_1 -in $tm.frm_inserts -row 3 -column 3
grid $tm.ent_insert_1  -in $tm.frm_inserts -row 3 -column 4
grid $tm.but_insert_1  -in $tm.frm_inserts -row 3 -column 5 -padx 10

grid $tm.lbl_insert_2  -in $tm.frm_inserts -row 4 -column 3 -columnspan 3 -sticky w -pady 10
grid $tm.txt_insert_2  -in $tm.frm_inserts -row 4 -column 2 -padx 10 -rowspan 2 -pady 5
grid $tm.lbl_insert_n_2 -in $tm.frm_inserts -row 5 -column 3
grid $tm.ent_insert_2  -in $tm.frm_inserts -row 5 -column 4
grid $tm.but_insert_2  -in $tm.frm_inserts -row 5 -column 5 -padx 10

grid $tm.lbl_insert_3  -in $tm.frm_inserts -row 6 -column 3 -columnspan 2 -sticky w -pady 10
grid $tm.txt_insert_3  -in $tm.frm_inserts -row 6 -column 2 -rowspan 2 -pady 5
grid $tm.but_insert_3  -in $tm.frm_inserts -row 7 -column 4

# _______________________________________________________________________
# The Theme Manual Pages(tm) Page 6
set tm [$tp.tnb_manual add -label "End" -command "defaulter 6"]
set tm6 $tm

frame $tm.frm_end
label $tm.lbl_end -text {Page End} -font $heading
iwidgets::optionmenu $tm.om_inserts -labeltext "Insert Codes :" -labelpos w -command "insertCode $tm txt_end_code om_inserts"
$tm.om_inserts insert end "Insert" "Main_Folder_Path" "Main_Folder_Name" "Page_Title" "No_of_Files" "Date" "Time"
iwidgets::scrolledtext $tm.txt_end_code -height 290 -width 5i -textfont $editing \
	-wrap none -vscrollmode dynamic  -hscrollmode dynamic

grid $tm.frm_end  -in $tm -row 1 -column 1 -sticky n
grid $tm.lbl_end  -in $tm.frm_end -row 1 -column 1 -sticky w
grid $tm.om_inserts -in $tm.frm_end -row 1 -column 2 -sticky e
grid $tm.txt_end_code -in $tm.frm_end -row 2 -column 1 -columnspan 2 -sticky ew

# _______________________________________________________________________
# The Theme Manual Pages(tm) Page 7
set tm [$tp.tnb_manual add -label "Files" -command "defaulter 7"]
set tm7 $tm

label $tm.lbl_heading  -text {Files needed for this theme} -font $heading
frame $tm.frm_main -bd 1 -relief raised
label $tm.lbl_desc -text "Please specify which all files must be copied for the proper functioning of the theme. You can include image, script, stylesheets and other html files. All the specified files will be copied to the output folder. If you wish to save this theme, all the files must be kept in \"$themes_folder\" folder." -wraplength 500

frame $tm.frm_files -bd 2 -relief ridge
button $tm.but_add -text {Add Files} -command "addFile $tm 1"
button $tm.but_remove -text {Remove Files} -command "deleteSelected $tm 1"
button $tm.but_clear -text {Clear List} -command "$tm.slb delete 0 end"

iwidgets::scrolledlistbox $tm.slb

frame $tm.frm_path -bd 1 -relief sunken
label $tm.lbl_path -text {Path for files}
entry $tm.ent_path
label $tm.lbl_path_desc -text "This will be the folder where all the files will be kept in relation to the index file." -wraplength 300

#Geometry
grid $tm.lbl_heading -in $tm -row 1 -column 1
grid $tm.frm_main -in $tm -row 2 -column 1 -pady 2 -ipadx 3
grid $tm.lbl_desc   -in $tm.frm_main -row 1 -column 1 -columnspan 2 -pady 10

grid $tm.frm_files  -in $tm.frm_main -row 2 -column 1 -sticky w -padx 5
grid $tm.but_add    -in $tm.frm_files -row 1 -column 1 -sticky w -padx 5 -pady 10
grid $tm.but_remove -in $tm.frm_files -row 2 -column 1 -sticky w -padx 5 -pady 10
grid $tm.but_clear  -in $tm.frm_files -row 3 -column 1 -sticky w -padx 5 -pady 10

grid $tm.slb        -in $tm.frm_main -row 2 -column 2 -sticky we

grid $tm.frm_path   -in $tm.frm_main -row 3 -column 1 \
		-columnspan 2 -sticky w -ipadx 3 -ipady 3 -padx 5 -pady 5
grid $tm.lbl_path   -in $tm.frm_path -row 1 -column 1
grid $tm.ent_path   -in $tm.frm_path -row 1 -column 2
grid $tm.lbl_path_desc -in $tm.frm_path -row 1 -column 3

grid columnconfigure $tm.frm_main 2 -weight 0 -minsize 300

#########################################################################

#The Theme Manual Page to view first
$tp.tnb_manual view "Introduction"

#########################################################################

# ----------------------------------------------------------------------
# The Theme Pages(tp) Page 3
set tp [$page.tnb_themes add -label "Saving Themes"]
set tp3 $tp

label $tp.lbl_heading_saving -text {Saving Themes} -font $heading

frame $tp.frm_theme_saving -relief sunken -bd 1
label $tp.lbl_theme_name -text {Name of the Theme : }
entry $tp.ent_theme_name

label $tp.lbl_theme_desc -text {Enter a brief describtion of this theme...}
iwidgets::scrolledtext $tp.txt_theme_desc -height 200 -width 400 -textfont $editing

button $tp.but_save_theme -text {Save Theme} -command "saveTheme $tp"

#Geometry
grid $tp.lbl_heading_saving -in $tp -row 1 -column 1
grid $tp.frm_theme_saving -in $tp -row 2 -column 1 -sticky w -pady 20 -ipadx 5 -ipady 5
grid $tp.lbl_theme_name -in $tp.frm_theme_saving -row 1 -column 1 -sticky w
grid $tp.ent_theme_name -in $tp.frm_theme_saving -row 1 -column 2 -sticky w

grid $tp.lbl_theme_desc -in $tp -row 3 -column 1 -sticky w
grid $tp.txt_theme_desc -in $tp -row 4 -column 1 -sticky w

grid $tp.but_save_theme -in $tp -row 5 -column 1 -sticky w -pady 10

#The Theme Page to view first
$page.tnb_themes view "Themes"

# ----------------------------------------------------------------------
# Page #3
# ----------------------------------------------------------------------
set page [.tnb add -label "Result"]
set page3 $page
#The file to be saved
frame $page.frm_main -borderwidth 1 -relief raised

label $page.lbl_file -text "Chose the file where the result must be saved" \
	-font "-Adobe-Helvetica-Bold-R-Normal--*-120-*-*-*-*-*-*"
frame $page.frm_results
#The result file
frame $page.frm_result_file -padx 5
entry $page.ent_file -width 50
button $page.but_file_browse -text {Browse...} -command "findResultFile $page"
#The Title of the page
frame $page.frm_title -padx 5 -pady 5
label $page.lbl_title -text "Title of Page"
entry $page.ent_title

checkbutton $page.ckb_case_fixing -variable case_fixing -text {Fix Case}
$page.ckb_case_fixing select

button $page.but_generate -text {Make Code} -command "makeCode $page"

#Code Area
frame $page.frm_code
text $page.txt_code -height 15 -wrap none \
	-yscrollcommand "$page.srl_code_y set" -xscrollcommand "$page.srl_code_x set"
scrollbar $page.srl_code_y -command "$page.txt_code yview" -orient v
scrollbar $page.srl_code_x -command "$page.txt_code xview" -orient h
#Code Control Buttons
frame $page.frm_code_buts
button $page.but_save_file  -text {Save File}  -command "saveResult $page" -state disabled
button $page.but_open       -text {Open In Browser} -command "opener $page" -state disabled
button $page.but_clear_code -text {Clear Code} -command "$page.txt_code delete 1.0 end"


#Geometry Management
#The Main Frame
grid $page.frm_main -in $page -row 1 -column 1 -sticky ns -ipadx 2 -ipady 2
#Label
grid $page.lbl_file -in $page.frm_main -row 1 -column 1 -sticky w

grid $page.frm_results -in $page.frm_main -row 2 -column 1 -sticky w
#The File selection committie
grid $page.frm_result_file -in $page.frm_results     -row 1 -column 1 -pady 10
grid $page.ent_file        -in $page.frm_result_file -row 1 -column 1
grid $page.but_file_browse -in $page.frm_result_file -row 1 -column 2
#File Title
grid $page.frm_title -in $page.frm_results -row 2 -column 1 -sticky w
grid $page.lbl_title -in $page.frm_title   -row 1 -column 1
grid $page.ent_title -in $page.frm_title   -row 1 -column 2

grid $page.ckb_case_fixing -in $page.frm_results -row 1 -column 2 -rowspan 2

grid $page.but_generate -in $page.frm_main -row 3 -column 1 -pady 5
#The Code area
grid $page.frm_code -in $page.frm_main -row 4 -column 1
grid $page.txt_code -in $page.frm_code -row 1 -column 1 -sticky ns
grid $page.srl_code_y -in $page.frm_code -row 1 -column 2 -sticky ns
grid $page.srl_code_x -in $page.frm_code -row 2 -column 1 -sticky we
#Code Control Buttons
grid $page.frm_code_buts -in $page.frm_code -row 3 -column 1 -columnspan 2
grid $page.but_save_file  -in $page.frm_code_buts -row 1 -column 1 -padx 30
grid $page.but_open		  -in $page.frm_code_buts -row 1 -column 2 -padx 30
grid $page.but_clear_code -in $page.frm_code_buts -row 1 -column 3 -padx 30

#The Page that appears first
.tnb view "File Selction"

#This will be done at first
# proc init { page } {
# 	loadList $page
# }
# init $page1

#Make it unresizable
catch {wm resizable . 0 0}

######################################  Explanations  ################################
#Exlpanation 1. Folder In/Out Structure
#		My plan was to make the sturctue in this way
# 			Folder1 structure begin
# 				File
# 				FIle
# 				Folder2 structure begin
# 					File
# 					File
# 					File
# 				Folder2 structure end
# 		Folder1 structure end
#
# 		But what happend was like this - 
# 			Folder1 structure begin
# 				File
# 				File
# 			Folder1 structure end
# 				Folder2 structure begin
# 					File
# 					File
# 					File
# 				Folder2 structure end

##########################################################################################
# Next Version
# ------------
#1. A proper sorting algoritham.
#2. Writing to multiple files
#3. Clear up the code. 
#	a. The defaulter function should be called once, when the 'Manual' button is pressed.
#   b. Try to minimize the use of Iwidgets
#4. Add a button to the 'Insert' Function. If the same thing is chosen, it won't insert.
#5. %User_Input% - User will be asked to input the contents of that region when that is 
#		encountered
#6. Overwriting Themes.