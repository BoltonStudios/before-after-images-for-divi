/*
// Update Before & After Image module styles
export function updateModuleStyles( wrapper, container, beforeImage, afterImage, sliderOffset, sliderHandle ){

    if( wrapper ){

        // We can use the dimensions of one image to set the dimensions of the wrapper.
        // Either the "before" or "after" image dimensions can represent the size selected for both images.
        // It doesn't matter which is passed to the function.
        var sizeSelected = {
            width: beforeImage.getAttribute( "width"),
            height: beforeImage.getAttribute( "height")
        };
        var moduleSize = getModuleSize( wrapper, beforeImage, sizeSelected );
        
        // Set wrapper styles
        wrapper.style.width = '100%';
        wrapper.style.width = moduleSize.width + 'px';

        // Set container styles
        var placeholderImageSrc = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg==';
        container.style.background = 'url(' + placeholderImageSrc + ') top left no-repeat';
        container.style.backgroundSize = 'cover';
        container.style.width = moduleSize.width + 'px';
        container.style.height = moduleSize.height;

        if( sizeSelected.height < moduleSize.height ){

            container.style.paddingBottom = ( sizeSelected.height/sizeSelected.width ) * 100 + '%';
        } else{

            container.style.paddingBottom = ( beforeImage.naturalHeight / beforeImage.naturalWidth ) * 100 + '%';
        }
        
        // Set "before" image styles.
        beforeImage.style.clip = 'rect(0px, ' + ( moduleSize.width * sliderOffset ) + 'px, ' + container.offsetHeight + 'px, 0px)';
        beforeImage.style.height = moduleSize.height;
        
        // Set "after" image styles.
        afterImage.style.clip = 'rect(0px, ' + moduleSize.width + 'px, ' + container.offsetHeight + 'px, ' + ( moduleSize.width * sliderOffset ) + 'px)';
        afterImage.style.height = moduleSize.height;
        
        // Set handle styles.
        sliderOffset = sliderHandle.getAttribute('data-slider-offset');
        sliderHandle.style.left = moduleSize.width * sliderOffset + 'px';
    }
}*/
/*
export function getModuleSize( wrapper, container, beforeImage, sizeSelected ){

        // Get the wrapper width
        var wrapperWidth = wrapper.offsetWidth;
        
        // Get the width and height of the images.
        var beforeImageWidth = beforeImage.naturalWidth;
        var beforeImageHeight = beforeImage.naturalHeight;
        
        // Set dimensions for the module output.
        var moduleWidth = beforeImageWidth;
        var moduleHeight = beforeImageHeight;
        
        // If the "before" image width is 0, set arbitrary default width.
        if( beforeImageWidth === 0 ){

            moduleWidth = '375';
        } 

        // If the "before" image width exceeds the wrapper width, set the width property to the wrapper width.
        if( beforeImageWidth > wrapperWidth ){

            moduleWidth = wrapperWidth;
        }

        // If the current width reference (and thus both the "before" image width and the wrapper width) are greater than the selected size width, set width reference to the selected size width.
        if( ( moduleWidth > sizeSelected.width ) ){

            moduleWidth = sizeSelected.width;
        }

        // If "before" image height is 0, set arbitrary default height.
        if( beforeImageHeight === 0 ){
            
            moduleHeight = '220px';
        } else{
            
            moduleHeight = 'auto';
        }

        // Give width and height properties to size object.
        var size = {
            width: moduleWidth,
            height: moduleHeight,
            containerOffsetWidth: container.offsetWidth,
            containerOffsetHeight: container.offsetHeight,
            beforeImageWidth: beforeImageWidth,
            beforeImageHeight: beforeImageHeight
        }

        return size;
}*/
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
export function generateStyles( imageAttributes, selectedSizeAttributes, sliderOffset, sliderOffsetString ){

    // Set the width and height to match the size selected by the user
    var width = selectedSizeAttributes.width;
    var height = selectedSizeAttributes.height;

    // In case the user selected "full size", set the width and height to the image dimensions
    if( selectedSizeAttributes.didSelectFullSize == true ){
        width = (imageAttributes.beforeImage.width >= imageAttributes.afterImage.width) ? imageAttributes.beforeImage.width : imageAttributes.afterImage.width;
        height = (imageAttributes.beforeImage.height >= imageAttributes.afterImage.height) ? imageAttributes.beforeImage.height : imageAttributes.afterImage.height;
    }

    var wrapperStyles = {
        width: width + 'px',
        maxWidth: '100%',
        marginTop: 0,
        marginRight: 'auto',
        marginBottom: 0,
        marginLeft: 'auto'
    }
    switch( imageAttributes.alignment ){
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