import { registerBlockType } from "@wordpress/blocks";
import ServerSideRender from "@wordpress/server-side-render";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";

registerBlockType("goodmotion/block-gm-mailchimp-form", {
	title: __("GM Mailchimp Form", "gm-mailchimp-form"),
	description: __(
		"Block for display newsletter form subscription",
		"gm-mailchimp-form"
	),
	icon: "email",
	category: "goodmotion-blocks",
	example: {},
	attributes: {},
	edit: (props) => {
		const blockProps = useBlockProps();
		return (
			<div {...blockProps}>
				<ServerSideRender block="goodmotion/block-gm-mailchimp-form" />
			</div>
		);
	},
	// save
});
