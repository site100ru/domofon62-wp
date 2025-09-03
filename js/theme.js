// Dynamic favicon
function dynamicFavicon() {
	var delay		= 1500;
	var link 		= document.getElementById('favicon');
	var currentNum	= 0;
	var head		= document.getElementsByTagName('head')[0];
	var favicons	= [
		'https://domofon62.ru/wp-content/themes/domoftwo/img/ico/favicon.svg',
		'https://domofon62.ru/wp-content/themes/domoftwo/img/ico/favicon-3.svg'
	];

	setInterval(function() {
		document.getElementById("favicon").remove();
		link.href = favicons[currentNum];
		head.append(link);
		currentNum++;
		if ( currentNum >= favicons.length ) {
			currentNum = 0;
		}
	}, delay );
}

dynamicFavicon();