/*
	作った人：ショウ
	http://furrytail.sakura.ne.jp/
*/

//★クラス //

/**
	@brief アイコンメーカークラス。
*/
Maker = function(){

	//■処理 //

	/**
		@brief アイコン画像を更新する。
	*/
	this.updateResultImage = function() //
	{
		this.resultContext.clearRect( 0 , 0 , this.resultCanvas.width , this.resultCanvas.height );

		for( var $i = 0 ; this.maxLayer >= $i ; ++$i ) //全てのレイヤーを処理
		{
			var $image = document.querySelector( '[data-mklayer="' + $i + '"][data-mkselect]' );

			if( $image ) //選択されている素材がある場合
			{
				if( $image.getAttribute( 'data-mkclip' ) )
					{ this.clipImage( $image ); }
				else if( $image.getAttribute( 'data-mkcolor' ) )
					{ this.drawColorImage( $image ); }
				else
					{ this.drawImage( $image ); }
			}
		}

		this.resultImage.setAttribute( 'src' , this.resultCanvas.toDataURL() );
	}

	/**
		@brief 指定の画像を内部キャンバスに描画する。
	*/
	this.drawImage = function( $iImage ) //
	{
		this.workContext.clearRect( 0 , 0 , this.workCanvas.width , this.workCanvas.height );
		this.workContext.drawImage( $iImage , 0 , 0 , this.workCanvas.width , this.workCanvas.height );

		var $image = this.workContext.getImageData( 0 , 0 , this.workCanvas.width , this.workCanvas.height );

		for( var $i = 0 ; $image.data.length > $i ; $i += 4 ) //全てのピクセルを処理
		{
			$image.data[ $i ]     = this.lineColor.red   * ( 255 - $image.data[ $i ] )     + this.fillColor.red   * $image.data[ $i ];
			$image.data[ $i + 1 ] = this.lineColor.green * ( 255 - $image.data[ $i + 1 ] ) + this.fillColor.green * $image.data[ $i + 1 ];
			$image.data[ $i + 2 ] = this.lineColor.blue  * ( 255 - $image.data[ $i + 2 ] ) + this.fillColor.blue  * $image.data[ $i + 2 ];
		}

		this.workContext.putImageData( $image , 0 , 0 );
		this.resultContext.drawImage( this.workCanvas , 0 , 0 , this.resultCanvas.width , this.resultCanvas.height );
	}

	/**
		@brief 指定の画像を色を変更せずに内部キャンバスに描画する。
	*/
	this.drawColorImage = function( $iImage ) //
		{ this.resultContext.drawImage( $iImage , 0 , 0 , this.resultCanvas.width , this.resultCanvas.height ); }

	/**
		@brief 指定の画像を使って内部キャンバスをマスクする。
	*/
	this.clipImage = function( $iImage ) //
	{
		this.workContext.clearRect( 0 , 0 , this.workCanvas.width , this.workCanvas.height );
		this.workContext.drawImage( $iImage , 0 , 0 , this.workCanvas.width , this.workCanvas.height );

		var $workImage   = this.workContext.getImageData( 0 , 0 , this.workCanvas.width , this.workCanvas.height );
		var $resultImage = this.resultContext.getImageData( 0 , 0 , this.resultCanvas.width , this.resultCanvas.height );

		for( var $i = 0 ; $resultImage.data.length > $i ; $i += 4 ) //全てのピクセルを処理
		{
			$resultImage.data[ $i + 3 ] = ( $resultImage.data[ $i + 3 ] - $workImage.data[ $i + 3 ] );
			$workImage.data[ $i + 3 ]   = ( 255 * 3 - $workImage.data[ $i ] - $workImage.data[ $i + 1 ] - $workImage.data[ $i + 2 ] ) / 3 * $workImage.data[ $i + 3 ] / 255;

			$workImage.data[ $i ]     = this.lineColor.red   * 255;
			$workImage.data[ $i + 1 ] = this.lineColor.green * 255;
			$workImage.data[ $i + 2 ] = this.lineColor.blue  * 255;
		}

		this.resultContext.putImageData( $resultImage , 0 , 0 );
		this.workContext.putImageData( $workImage , 0 , 0 );
		this.resultContext.drawImage( this.workCanvas , 0 , 0 , this.resultCanvas.width , this.resultCanvas.height );
	}

	/**
		@brief 指定の画像を選択状態にする。
	*/
	this.selectImage = function( $iImage ) //
	{
		var $layer = $iImage.getAttribute( 'data-mklayer' );
		var $image = document.querySelector( '[data-mklayer="' + $layer + '"][data-mkselect]' );

		$image.setAttribute( 'class' , $image.getAttribute( 'class' ).replace( 'mkselect' , '' ) );
		$image.removeAttribute( 'data-mkselect' );
		$iImage.setAttribute( 'class' , $iImage.getAttribute( 'class' ) + ' mkselect' );
		$iImage.setAttribute( 'data-mkselect' , true );
	}

	/**
		@brief 指定の色を使用する。
	*/
	this.selectColor = function( $iColor )
	{
		var $lineColor = $iColor.getAttribute( 'data-mkline' );
		var $fillColor = $iColor.getAttribute( 'data-mkfill' );

		if( $lineColor ) //ラインの色指定がある場合
		{
			var $color = $lineColor.split( ',' );

			this.lineColor.red   = parseFloat( $color[ 0 ] );
			this.lineColor.green = parseFloat( $color[ 1 ] );
			this.lineColor.blue  = parseFloat( $color[ 2 ] );

			var $current = document.querySelector( '[data-mkline][data-mkselect]' );

			$current.setAttribute( 'class' , $current.getAttribute( 'class' ).replace( 'mkselect' , '' ) );
			$current.removeAttribute( 'data-mkselect' );
			$iColor.setAttribute( 'class' , $iColor.getAttribute( 'class' ) + ' mkselect' );
			$iColor.setAttribute( 'data-mkselect' , true );
		}

		if( $fillColor ) //塗りつぶしの色指定がある場合
		{
			var $color = $fillColor.split( ',' );

			this.fillColor.red   = parseFloat( $color[ 0 ] );
			this.fillColor.green = parseFloat( $color[ 1 ] );
			this.fillColor.blue  = parseFloat( $color[ 2 ] );

			var $current = document.querySelector( '[data-mkfill][data-mkselect]' );

			$current.setAttribute( 'class' , $current.getAttribute( 'class' ).replace( 'mkselect' , '' ) );
			$current.removeAttribute( 'data-mkselect' );
			$iColor.setAttribute( 'class' , $iColor.getAttribute( 'class' ) + ' mkselect' );
			$iColor.setAttribute( 'data-mkselect' , true );
		}
	}

	//■初期化 //

	this.resultImage   = document.querySelector( 'IMG[data-mkresult]' );
	this.layerImage    = document.querySelectorAll( 'IMG[data-mklayer]' );
	this.lineColors    = document.querySelectorAll( '[data-mkline]' );
	this.fillColors    = document.querySelectorAll( '[data-mkfill]' );
	this.resultCanvas  = document.createElement( 'canvas' );
	this.resultContext = this.resultCanvas.getContext( '2d' );
	this.workCanvas    = document.createElement( 'canvas' );
	this.workContext   = this.workCanvas.getContext( '2d' );
	this.lineColor     = { 'red' : 0 , 'green' : 0 , 'blue' : 0 };
	this.fillColor     = { 'red' : 1 , 'green' : 1 , 'blue' : 1 };
	this.maxLayer      = 0;

	if( !this.resultImage ) //出力先のIMGタグを絞り込めない場合
		{ throw 'アイコンの出力先を設定できません。「data-mkresult」属性を持つIMGタグをページ内のどこかに"1つだけ"記述してください。'; }

	if( !this.layerImage.length ) //素材のIMGタグが見つからない場合
		{ throw 'アイコン素材が1つもありません。「data-mklayer」属性を持つIMGタグをページ内のどこかに記述してください。'; }

	this.resultCanvas.width  = this.resultImage.getAttribute( 'width' );
	this.resultCanvas.height = this.resultImage.getAttribute( 'height' );
	this.workCanvas.width    = this.resultImage.getAttribute( 'width' );
	this.workCanvas.height   = this.resultImage.getAttribute( 'height' );

	var $maker = this;

	for( var $i = 0 ; this.layerImage.length > $i ; ++$i ) //全てのアイコン素材を処理
	{
		var $image = this.layerImage[ $i ];

		$image.addEventListener( 'click'     , function(){ $maker.selectImage( this ); $maker.updateResultImage(); } );
		$image.addEventListener( 'mouseover' , function(){ addTooltip( this ); } );
		$image.addEventListener( 'mouseout'  , function(){ deleteTooltip( this ); } );

		if( $image.getAttribute( 'data-mkselect' ) ) //初期選択値の場合
			{ this.selectImage( $image ); }

		if( this.maxLayer < $image.getAttribute( 'data-mklayer' ) ) //現在のレイヤーカウントより大きい場合
			{ this.maxLayer = $image.getAttribute( 'data-mklayer' ); }
	}

	for( var $i = 0 ; this.lineColors.length > $i ; ++$i ) //全てのライン色を処理
	{
		var $color = this.lineColors[ $i ];

		$color.addEventListener( 'click' , function(){ $maker.selectColor( this ); $maker.updateResultImage(); } );

		if( $color.getAttribute( 'data-mkselect' ) ) //初期選択値の場合
			{ this.selectColor( $color ); }
	}

	for( var $i = 0 ; this.fillColors.length > $i ; ++$i ) //全ての塗りつぶし色を処理
	{
		var $color = this.fillColors[ $i ];

		$color.addEventListener( 'click' , function(){ $maker.selectColor( this ); $maker.updateResultImage(); } );

		if( $color.getAttribute( 'data-mkselect' ) ) //初期選択値の場合
			{ this.selectColor( $color ); }
	}

	this.updateResultImage();
};

function addTooltip( $iImage )
	{
		var $span      = document.createElement( 'span' );
		var $innerSpan = document.createElement( 'span' );

		$span.setAttribute( 'class' , 'mktooltipcontainer' );
		$innerSpan.setAttribute( 'class' , 'mktooltip' );
		$innerSpan.innerText = $iImage.getAttribute( 'alt' );

		$span.appendChild( $innerSpan );
		$iImage.parentNode.insertBefore( $span , $iImage );
	}

function deleteTooltip( $iImage )
	{ document.querySelector( '.mktooltip' ).parentNode.removeChild( document.querySelector( '.mktooltip' ) ); }

//★処理 //

window.addEventListener( 'load' , function(){ new Maker(); } );
