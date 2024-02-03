export function getImageSrcAtSize( image, size ){
    //
    // Function description coming soon.
    //

    // Initialize variables.
    let src = ''
    let url = document.createElement( 'a' )
    let pathAttributes = ['']

    // Extract integers from the 'size' input.
    const sizes = size.split('.');
    const width = parseInt( sizes[0].match(/\d+/)[0] )
    const height = parseInt( sizes[1].match(/\d+/)[0] )

    // Pass the image string to the local anchor element to make it parse-able. 
    url.href = image
    pathAttributes = url.pathname.split('.')

    // Construct a string to use for the image 'src' attribute.
    src = url.protocol + '//' + url.hostname
    src += pathAttributes[0].replace( '-scaled', '' )
    src += '-' + width + 'x' + height
    src += '.' + pathAttributes[1]

    // Package our values in a new object.
    const imageData = { url: src, width, height }

    // Return the object.
    return imageData
}

export function getStyles( alignment, sizes, offset ){
    //
    // Function description coming soon.
    //

    // Initialize variables.
    const placeholder = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg=='
    const width         = sizes.width
    const height        = sizes.height
    const marginRight   = ( alignment === "right" ) ? 0 : "auto"
    const marginLeft    = ( alignment === "left" ) ? 0 : "auto"

    const wrapper = {
        width: width + 'px',
        maxWidth: '100%',
        marginTop: 0,
        marginRight: marginRight,
        marginBottom: 0,
        marginLeft: marginLeft
    }

    const container = {
        background: 'url(' + placeholder + ') top left no-repeat',
        backgroundSize: 'cover',
        maxWidth: '100%',
        width: width + 'px',
        height: height + 'px',
        minHeight: '150px',
        paddingBottom: 0
    }

    const before = {
        height: height + 'px',
        clip: 'rect(0px, ' + (width * offset) + 'px, ' + height + 'px, 0px)'
    }

    const after = {
        height: height + 'px',
        clip: 'rect(0px, ' + width + 'px, ' + height + 'px, ' + (width * offset) + 'px)'
    }

    const overlay = {
        width: width + 'px',
        maxWidth: '100%'
    }

    const handle = {
        left: (width * offset) + 'px'
    }

    const styles = {
        wrapper: wrapper,
        container: container,
        beforeImage: before,
        afterImage: after,
        overlay: overlay,
        handle: handle
    }

    //
    return styles
}

export function getOrientationClasses(
    selectedWidth,
    selectedHeight,
    moduleSizes,
    classes = ['']
){

    // Initialize a new classes variable by concatenating strings from the classes array.
    let classes = classes.join ( " " )

    const before = {}
    const after = {}

  const beforeOrientation = (moduleSizes.before.naturalWidth >= moduleSizes.before.naturalHeight) ? 'landscape' : 'portrait'
  const beforeAspectRatio = (beforeOrientation === 'landscape') ? moduleSizes.before.naturalHeight / moduleSizes.before.naturalWidth : moduleSizes.before.naturalWidth / moduleSizes.before.naturalHeight
  const afterOrientation = (moduleSizes.after.naturalWidth >= moduleSizes.after.naturalHeight) ? 'landscape' : 'portrait'
  const afterAspectRatio = (afterOrientation === 'landscape') ? moduleSizes.after.naturalHeight / moduleSizes.after.naturalWidth : moduleSizes.after.naturalWidth / moduleSizes.after.naturalHeight
  const beforeHeightAtFullSizeWidth = Math.trunc(moduleSizes.slider.fullSizeWidth * beforeAspectRatio)
  const beforeWidthAtFullSizeHeight = Math.trunc(moduleSizes.slider.fullSizeHeight * beforeAspectRatio)
  const afterHeightAtFullSizeWidth = Math.trunc(moduleSizes.slider.fullSizeWidth * afterAspectRatio)
  const afterWidthAtFullSizeHeight = Math.trunc(moduleSizes.slider.fullSizeHeight * afterAspectRatio)

  let comparativeWidth = ''
  if (beforeWidthAtFullSizeHeight > afterWidthAtFullSizeHeight) {
    comparativeWidth = 'before-width-at-full-size-is-greater'
  } else if (beforeWidthAtFullSizeHeight < afterWidthAtFullSizeHeight) {
    comparativeWidth = 'after-width-at-full-size-is-greater'
  } else {
    comparativeWidth = 'before-width-at-full-size-is-equal'
  }

  let comparativeHeight = ''
  if (beforeHeightAtFullSizeWidth > afterHeightAtFullSizeWidth) {
    comparativeHeight = 'before-height-at-full-size-is-greater'
  } else if (beforeHeightAtFullSizeWidth < afterHeightAtFullSizeWidth) {
    comparativeHeight = 'after-height-at-full-size-is-greater'
  } else {
    comparativeHeight = 'before-height-at-full-size-is-equal'
  }

    classes += ' ' + comparativeWidth + ' '
    classes += ' ' + comparativeHeight + ' '
    classes += (selectedHeight > selectedWidth) ? ' is-portrait-size ' : ' is-landscape-size '
    classes += (moduleSizes.before.naturalHeight > moduleSizes.before.naturalWidth) ? ' has-portrait-before-image ' : ' has-landscape-before-image '
    classes += (moduleSizes.after.naturalHeight > moduleSizes.after.naturalWidth) ? ' has-portrait-after-image ' : ' has-landscape-after-image '
    classes = classes.replace(/ +(?= )/g, '').trim() // Replace unnecessary spaces.
  
    // Return String containing CSS class names.
    return classes
}
