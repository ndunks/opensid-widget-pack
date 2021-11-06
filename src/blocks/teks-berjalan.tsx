import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import { ChangeEvent, KeyboardEvent } from 'react';


registerBlockType('opensid-widget-pack/teks-berjalan', {
    apiVersion: 2,
    title: 'OpenSID: Teks Berjalan',
    icon: 'megaphone',
    category: 'widgets',
    html: true,
    attributes: {
        "text": {
            "type": "string",
            "default": "Teks Berjalan.."
        },
        "post_count": {
            "type": "number",
            "default": 5
        },
        "time": {
            "type": "number",
            "default": 10
        },
        "post_category": {
            "type": "string"
        }
    },
    edit({ attributes, setAttributes }, what) {
        const blockProps = useBlockProps();

        const onChange = (e: ChangeEvent<HTMLInputElement>) => {
            const v = e.currentTarget.value;
            const isNumeric = v.match(/^\d+$/);
            setAttributes({
                [e.currentTarget.name]:
                isNumeric ? parseInt(v) : v
            });
        }

        return (
            <div {...blockProps}>
                <input type="number" min="0" name="time"
                    style={{ maxWidth: '50px' }}
                    value={attributes.time}
                    onChange={onChange}
                />
                <input type="number" min="0" name="post_count"
                    style={{ maxWidth: '50px' }}
                    value={attributes.post_count}
                    onChange={onChange}
                />
                <input name="text"
                    value={attributes.text}
                    onChange={onChange}
                />
                <hr />
                <ServerSideRender
                    block="opensid-widget-pack/teks-berjalan"
                    attributes={attributes}
                />
            </div>
        );
    },
});