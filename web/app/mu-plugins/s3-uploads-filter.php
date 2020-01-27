<?php
/*
 * Plugin Name: S3 Uploads Filter
 * Description: Internal custom filter for allowing an other S3 endpoint than Amazon.
 * Version: 1.0
 * Author: jlannoy
 * Author URI: https://github.com/jlannoy
 */

add_filter( 's3_uploads_s3_client_params', function ( $params ) {
	if ( defined( 'S3_UPLOADS_ENDPOINT' ) ) {
		$params['endpoint'] = S3_UPLOADS_ENDPOINT;
	}
	return $params;
}, 5, 1 );
