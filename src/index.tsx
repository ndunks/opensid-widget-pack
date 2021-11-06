
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';
import './widgets/perangkat';

const blockStyle:any = {
    backgroundColor: '#900',
    color: '#fff',
    padding: '20px',
};

 
// registerBlockType( 'opensid_widget_pack/widget-1', {
//     apiVersion: 2,
//     title: 'Example: Basic (esnext)',
//     icon: 'universal-access-alt',
//     category: 'design',
//     example: {},
//     edit() {
//         const blockProps = useBlockProps( { style: blockStyle } );
//         return (
//             <div { ...blockProps }>Hello World (from the editor).</div>
//         );
//     },
//     save() {
//         const blockProps = useBlockProps.save( { style: blockStyle } );
 
//         return (
//             <div { ...blockProps }>
//                 Hello World (from the frontend).
//             </div>
//         );
//     },
// } );
const my: string = 'Hello World'


console.log('YES IM IN! XXX', my);