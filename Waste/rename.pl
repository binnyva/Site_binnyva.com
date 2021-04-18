#!/usr/bin/perl
# alias p='perl /var/www/html/binnyva/binnyva/rename.pl .'

$verbose = 1;
 
#Get the needed command line arguments
if(@ARGV) {
	$folder = $ARGV[0];
	unless (-d $folder)	{ #If argument is not a folder, exit with error
		print "Error : Argument($folder) not a folder.\n";
		exit -1;
	}
} else { # If no command line, print error, exit
	$folder = '.';
}

#Get the list of all files in the folder
chdir($folder) || die "Can't change to dir $folder:$!"; # Changes to specifed directory
my @LIST = <*.{htm,html}>; #Get all the file names of necessary files

my $total_files = $#LIST+1; #Count number of files
print "$total_files files to process...\n\n" if($verbose);

#Process every file in the list
my $file_count = 0;
FILE: foreach my $file (@LIST) {
	$file_count++;
	print "Processing File '$file' ($file_count/$total_files) " if($verbose);
	
	#Read the file
	if(!open (IN, "$file")) {
		print " - Error! Can't open $file for reading: $!\n";
		next FILE;
	}
	my @LINES=<IN>;
	close(IN);
	my $line_count=@LINES;
	
	my $data = "";
	my $dot_points = int($line_count/10);
	
	my $in_body = 0;
	my $meta = "";
	my $title = "";
	
	#Process the file - line by line
	for (my $i=1; $i<=$line_count; $i++) {
		$_ = $LINES[$i];

		if(
			/<META NAME="author" /i ||
			/<script[^>]*>layout\(\);?<\/script>/i ||
			/<script[^>]*>writeIn\(begin\);?<\/script>/i ||
			/<script>writer\(\)<\/script>/i ||
			/<script[^>]*>writeIn\(end\);?<\/script>/i ||
			/<script>layout\(\);localInit\(\)<\/script>/i ||
			/<script language="javascript" type="text\/javascript">writer\(\);<\/script>/i ||
			/<\/body>/i ||
			/<\/html>/i ||
			/<\/body><\/html>/i
		) {
			next;
		} else { #If nothing matchs, just use the current line - with out any replaces
			$in_body = 1 if(/<body/i);
			$in_body = 0 if(/<!-- Ending -->/i);
			$in_body = 0 if(/<\/body>/i);
			$title = $1 if(/<TITLE>(.+?)<\/TITLE>/i);
			$rel = $1 if(/href="(?:binny\/)?(.*?)default.css"/i);
			$meta .= "\$page -> addMetadata('$1','$2');\n" if(/<META NAME="([^"]+)" CONTENT="([^"]+)">/i);

			$data .= $_ if($in_body);
		}
		
		#Display a dot to show the progress.
		print "." if($i%$dot_points == 0 and $verbose);
	}
	
	$_ = "<?php\ninclude('".$rel."common.php');\n$meta\nprintTop('$title');\n?>\n" . $data . "\n<?php printEnd(); ?>";

	# XHTML Changes
	s#<br>#<br />#gi;
	s#<hr>#<hr />#gi;
	s#<img ([^>]+)([^/])>#<img \1\2 />#gi;
	s#<(/?)b>#<\1strong>#ig;
	s#<(/?)i>#<\1em>#ig;
	#Quoting the attributes
	s#<([^>]+)=(\d+)#<\L$1\E="\2"#g;
	s#<([^>]+)=(\d+)#<\L$1\E="\2"#g;
	s#<([^>]+)=(\d+)#<\L$1\E="\2"#g;
	
	#Lowercase all tags
	s#<(\/?)([A-Z]+)(\s|>)#<\1\L$2\E\3#g;
	
	s#<hr class="line">#<hr class="seperator" />#gi;
	
	#Our framework specific.
	s/ href="([^"]+)\.html?(#[^"]*)?"/ href="\1.php\2"/gi;
	s# href="\.\.\/$rel ?code([^"]+)"# href="http://www.bin-co.com$1"#g;
	s# href="\.\.\/$rel ?creation([^"]+)"# href="http://creationism.binnyva.com$1"#g;
	s# href="([^"]+/)index.(php|htm|html)"# href="\1"#g;
	s#<script>writeIn\(em\)<\/script>#<?=\$email_html?>#g;
	s#<body.*?>##g;

	$file_contents = $_;

	#Write the changed data back to the file
	$new_file = $1 . ".php" if($file =~ /(.+)\.html?/);
 	open (OUT, ">$new_file") || die "Error! Can't open $new_file for writing: $!\n";
 	print OUT $file_contents;
 	close(OUT);
 	print " [Done - $new_file] " if($verbose);
#	print $file_contents;
	
	print "($line_count Lines) Done\n" if($verbose);
}
