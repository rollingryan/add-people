const element = wp.element.createElement;
const peoplePostsDropdownControl = compose.compose(
	// withDispatch allows to save the selected post ID into post meta
	withDispatch(function(dispatch, props) {
		return {
			setMetaValue: function(metaValue) {
				dispatch('core/editor').editPost(
					{ meta: { [props.metaKey]: metaValue } }
				);
			}
		}
	}),
	// withSelect allows to get posts for our SelectControl and also to get the post meta value
	withSelect(function(select, props) {
		return {
			posts: select('core').getEntityRecords('postType', 'ap_person'),
			metaValue: select('core/editor').getEditedPostAttribute('meta')[props.metaKey],
		}
	}))(function(props) {
		// options for SelectControl
		let options = [];
 
		// if posts found
		if(props.posts) {
			options.push({ value: 0, label: 'Select someone...' });
			props.posts.forEach((post) => { // simple foreach loop
				options.push({value:post.id, label:post.title.rendered});
			});
		} else {
			options.push({ value: 0, label: 'Loading...' })
		}
 
		return el(SelectControl,
			{
				label: 'Select a Person...',
				options : options,
				onChange: function(content) {
					props.setMetaValue(content);
				},
				value: props.metaValue,
			}
		);
	}
);

wp.blocks.registerBlockType('ap-gutenberg/add-people-block', {
  title: 'Person', // Block name visible to user
  icon: 'businessman', // Toolbar icon can be either using WP Dashicons or custom SVG
  category: 'common', // Under which category the block would appear
  attributes: { // The data this block will be storing
    type: { type: 'string', default: 'default' }, // Notice box type for loading the appropriate CSS class. Default class is 'default'.
  },

  edit: function(props) {
    // Render block in the editor in edit mode
    return element('div',
      {
        className: 'notice-box notice-' + props.attributes.person
      },
      peoplePostsDropdownControl
    ); // End return
  },

  save: function(props) {
    // How our block renders on the frontend
    return null;
  }
});