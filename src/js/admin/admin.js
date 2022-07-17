jQuery(document).ready(function() {
	fullScreenModeBGone();
	welcomeToTheBlockEditorBGone();
});

function fullScreenModeBGone() {
	if (wp.data) {
		wp.data.select( "core/edit-post" ).isFeatureActive( "fullscreenMode" ) && wp.data.dispatch( "core/edit-post" ).toggleFeature( "fullscreenMode" );
	}
}

function welcomeToTheBlockEditorBGone() {
	if (wp.data) {
		wp.data.select( "core/edit-post" ).isFeatureActive( "welcomeGuide" ) && wp.data.dispatch( "core/edit-post" ).toggleFeature( "welcomeGuide" );
	}
}
