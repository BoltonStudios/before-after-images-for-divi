export function createImageSrcAtSize( image, size ){

    // Extract size integers from user input string.
    var sizeSelectedSplit = size.split(".");
    var width = parseInt(sizeSelectedSplit[0].match(/\d+/)[0]);
    var height = parseInt(sizeSelectedSplit[1].match(/\d+/)[0]);
    
    // Construct URL for image as the selected size.
    var sourceParsed = document.createElement('a');
    sourceParsed.href = image;
    var sourcePathSplit = sourceParsed.pathname.split(".");

    var imageSource = '';
    imageSource = sourceParsed.protocol + '//';
    imageSource += sourceParsed.hostname;
    imageSource += sourcePathSplit[0].replace( "-scaled", "" );
    imageSource += '-' + width + 'x' + height;
    imageSource += '.' + sourcePathSplit[1];
    var imageObject = {
        url: imageSource,
        width: width,
        height: height
    };
    return imageObject;
}
// export function updateStyles( isSizeFull, width, height, imageAlignment, sliderOffset, sliderOffsetString ){
export function generateStyles( alignment, selectedSizeAttributes, sliderOffset, sliderOffsetString ){

    // Set the width and height to match the size selected by the user
    var width = selectedSizeAttributes.width;
    var height = selectedSizeAttributes.height;

    var wrapperStyles = {
        width: width + 'px',
        maxWidth: '100%',
        marginTop: 0,
        marginRight: 'auto',
        marginBottom: 0,
        marginLeft: 'auto'
    }
    switch( alignment ){
        case( "left" ):
            wrapperStyles.marginLeft = 0;
            break;
        case( "right" ):
            wrapperStyles.marginRight = 0;
            break;
        default:
            break;
    }
    var placeholderImageSrc = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg==';
    var containerStyles = {
        background: 'url(' + placeholderImageSrc + ') top left no-repeat',
        backgroundSize: 'cover',
        maxWidth: '100%',
        width: width + 'px',
        height: height + 'px',
        minHeight: '150px',
        paddingBottom: 0
    }
    var beforeImageStyles = {
        height: height + 'px',
        clip: 'rect(0px, ' + (width*sliderOffset) + 'px, ' + height + 'px, 0px)'
    }
    var afterImageStyles = {
        height: height + 'px',
        clip: 'rect(0px, ' + width + 'px, ' + height + 'px, ' + (width*sliderOffset) + 'px)'
    }
    var overlayStyles = {
        width: width + 'px',
        maxWidth: '100%'
    }
    var handleStyles = {
        left: sliderOffsetString
    }
    var styles = {
        wrapper: wrapperStyles,
        container: containerStyles,
        beforeImage: beforeImageStyles,
        afterImage: afterImageStyles,
        overlay: overlayStyles,
        handle: handleStyles
    }
    return styles;
}
export function getOrientationClasses( beforeImage, afterImage, classes ){
    var classString = '';
    if( classes !== undefined ){
        for( var i = 0; i <= classes.length; i++){
            classString += ' ' + classes[i] + ' ';
        }
    }
    classString += (beforeImage.height > beforeImage.width) ? " before-portrait " : " before-landscape ";
    classString += (afterImage.height > afterImage.width) ? " after-portrait " : " after-landscape ";
    classString = classString.replace(/ +(?= )/g,'').trim(); // Replace unnecessary spaces.
    return classString;
}