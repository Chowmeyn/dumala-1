/**
 * @license Copyright (c) 2003-2024, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
/* eslint-disable @typescript-eslint/no-unused-vars */
/**
 * @module engine/model/node
 */
import TypeCheckable from './typecheckable.js';
import { CKEditorError, compareArrays, toMap } from '@ckeditor/ckeditor5-utils';
/**
 * Model node. Most basic structure of model tree.
 *
 * This is an abstract class that is a base for other classes representing different nodes in model.
 *
 * **Note:** If a node is detached from the model tree, you can manipulate it using it's API.
 * However, it is **very important** that nodes already attached to model tree should be only changed through
 * {@link module:engine/model/writer~Writer Writer API}.
 *
 * Changes done by `Node` methods, like {@link module:engine/model/element~Element#_insertChild _insertChild} or
 * {@link module:engine/model/node~Node#_setAttribute _setAttribute}
 * do not generate {@link module:engine/model/operation/operation~Operation operations}
 * which are essential for correct editor work if you modify nodes in {@link module:engine/model/document~Document document} root.
 *
 * The flow of working on `Node` (and classes that inherits from it) is as such:
 * 1. You can create a `Node` instance, modify it using it's API.
 * 2. Add `Node` to the model using `Batch` API.
 * 3. Change `Node` that was already added to the model using `Batch` API.
 *
 * Similarly, you cannot use `Batch` API on a node that has not been added to the model tree, with the exception
 * of {@link module:engine/model/writer~Writer#insert inserting} that node to the model tree.
 *
 * Be aware that using {@link module:engine/model/writer~Writer#remove remove from Batch API} does not allow to use `Node` API because
 * the information about `Node` is still kept in model document.
 *
 * In case of {@link module:engine/model/element~Element element node}, adding and removing children also counts as changing a node and
 * follows same rules.
 */
export default class Node extends TypeCheckable {
    /**
     * Creates a model node.
     *
     * This is an abstract class, so this constructor should not be used directly.
     *
     * @param attrs Node's attributes. See {@link module:utils/tomap~toMap} for a list of accepted values.
     */
    constructor(attrs) {
        super();
        /**
         * Parent of this node. It could be {@link module:engine/model/element~Element}
         * or {@link module:engine/model/documentfragment~DocumentFragment}.
         * Equals to `null` if the node has no parent.
         */
        this.parent = null;
        this._attrs = toMap(attrs);
    }
    /**
     * {@link module:engine/model/document~Document Document} that owns this root element.
     */
    get document() {
        return null;
    }
    /**
     * Index of this node in its parent or `null` if the node has no parent.
     *
     * Accessing this property throws an error if this node's parent element does not contain it.
     * This means that model tree got broken.
     */
    get index() {
        let pos;
        if (!this.parent) {
            return null;
        }
        if ((pos = this.parent.getChildIndex(this)) === null) {
            throw new CKEditorError('model-node-not-found-in-parent', this);
        }
        return pos;
    }
    /**
     * Offset at which this node starts in its parent. It is equal to the sum of {@link #offsetSize offsetSize}
     * of all its previous siblings. Equals to `null` if node has no parent.
     *
     * Accessing this property throws an error if this node's parent element does not contain it.
     * This means that model tree got broken.
     */
    get startOffset() {
        let pos;
        if (!this.parent) {
            return null;
        }
        if ((pos = this.parent.getChildStartOffset(this)) === null) {
            throw new CKEditorError('model-node-not-found-in-parent', this);
        }
        return pos;
    }
    /**
     * Offset size of this node. Represents how much "offset space" is occupied by the node in it's parent.
     * It is important for {@link module:engine/model/position~Position position}. When node has `offsetSize` greater than `1`, position
     * can be placed between that node start and end. `offsetSize` greater than `1` is for nodes that represents more
     * than one entity, i.e. {@link module:engine/model/text~Text text node}.
     */
    get offsetSize() {
        return 1;
    }
    /**
     * Offset at which this node ends in it's parent. It is equal to the sum of this node's
     * {@link module:engine/model/node~Node#startOffset start offset} and {@link #offsetSize offset size}.
     * Equals to `null` if the node has no parent.
     */
    get endOffset() {
        if (!this.parent) {
            return null;
        }
        return this.startOffset + this.offsetSize;
    }
    /**
     * Node's next sibling or `null` if the node is a last child of it's parent or if the node has no parent.
     */
    get nextSibling() {
        const index = this.index;
        return (index !== null && this.parent.getChild(index + 1)) || null;
    }
    /**
     * Node's previous sibling or `null` if the node is a first child of it's parent or if the node has no parent.
     */
    get previousSibling() {
        const index = this.index;
        return (index !== null && this.parent.getChild(index - 1)) || null;
    }
    /**
     * The top-most ancestor of the node. If node has no parent it is the root itself. If the node is a part
     * of {@link module:engine/model/documentfragment~DocumentFragment}, it's `root` is equal to that `DocumentFragment`.
     */
    get root() {
        // eslint-disable-next-line @typescript-eslint/no-this-alias, consistent-this
        let root = this;
        while (root.parent) {
            root = root.parent;
        }
        return root;
    }
    /**
     * Returns `true` if the node is inside a document root that is attached to the document.
     */
    isAttached() {
        // If the node has no parent it means that it is a root.
        // But this is not a `RootElement`, so it means that it is not attached.
        //
        // If this is not the root, check if this element's root is attached.
        return this.parent === null ? false : this.root.isAttached();
    }
    /**
     * Gets path to the node. The path is an array containing starting offsets of consecutive ancestors of this node,
     * beginning from {@link module:engine/model/node~Node#root root}, down to this node's starting offset. The path can be used to
     * create {@link module:engine/model/position~Position Position} instance.
     *
     * ```ts
     * const abc = new Text( 'abc' );
     * const foo = new Text( 'foo' );
     * const h1 = new Element( 'h1', null, new Text( 'header' ) );
     * const p = new Element( 'p', null, [ abc, foo ] );
     * const div = new Element( 'div', null, [ h1, p ] );
     * foo.getPath(); // Returns [ 1, 3 ]. `foo` is in `p` which is in `div`. `p` starts at offset 1, while `foo` at 3.
     * h1.getPath(); // Returns [ 0 ].
     * div.getPath(); // Returns [].
     * ```
     */
    getPath() {
        const path = [];
        // eslint-disable-next-line @typescript-eslint/no-this-alias, consistent-this
        let node = this;
        while (node.parent) {
            path.unshift(node.startOffset);
            node = node.parent;
        }
        return path;
    }
    /**
     * Returns ancestors array of this node.
     *
     * @param options Options object.
     * @param options.includeSelf When set to `true` this node will be also included in parent's array.
     * @param options.parentFirst When set to `true`, array will be sorted from node's parent to root element,
     * otherwise root element will be the first item in the array.
     * @returns Array with ancestors.
     */
    getAncestors(options = {}) {
        const ancestors = [];
        let parent = options.includeSelf ? this : this.parent;
        while (parent) {
            ancestors[options.parentFirst ? 'push' : 'unshift'](parent);
            parent = parent.parent;
        }
        return ancestors;
    }
    /**
     * Returns a {@link module:engine/model/element~Element} or {@link module:engine/model/documentfragment~DocumentFragment}
     * which is a common ancestor of both nodes.
     *
     * @param node The second node.
     * @param options Options object.
     * @param options.includeSelf When set to `true` both nodes will be considered "ancestors" too.
     * Which means that if e.g. node A is inside B, then their common ancestor will be B.
     */
    getCommonAncestor(node, options = {}) {
        const ancestorsA = this.getAncestors(options);
        const ancestorsB = node.getAncestors(options);
        let i = 0;
        while (ancestorsA[i] == ancestorsB[i] && ancestorsA[i]) {
            i++;
        }
        return i === 0 ? null : ancestorsA[i - 1];
    }
    /**
     * Returns whether this node is before given node. `false` is returned if nodes are in different trees (for example,
     * in different {@link module:engine/model/documentfragment~DocumentFragment}s).
     *
     * @param node Node to compare with.
     */
    isBefore(node) {
        // Given node is not before this node if they are same.
        if (this == node) {
            return false;
        }
        // Return `false` if it is impossible to compare nodes.
        if (this.root !== node.root) {
            return false;
        }
        const thisPath = this.getPath();
        const nodePath = node.getPath();
        const result = compareArrays(thisPath, nodePath);
        switch (result) {
            case 'prefix':
                return true;
            case 'extension':
                return false;
            default:
                return thisPath[result] < nodePath[result];
        }
    }
    /**
     * Returns whether this node is after given node. `false` is returned if nodes are in different trees (for example,
     * in different {@link module:engine/model/documentfragment~DocumentFragment}s).
     *
     * @param node Node to compare with.
     */
    isAfter(node) {
        // Given node is not before this node if they are same.
        if (this == node) {
            return false;
        }
        // Return `false` if it is impossible to compare nodes.
        if (this.root !== node.root) {
            return false;
        }
        // In other cases, just check if the `node` is before, and return the opposite.
        return !this.isBefore(node);
    }
    /**
     * Checks if the node has an attribute with given key.
     *
     * @param key Key of attribute to check.
     * @returns `true` if attribute with given key is set on node, `false` otherwise.
     */
    hasAttribute(key) {
        return this._attrs.has(key);
    }
    /**
     * Gets an attribute value for given key or `undefined` if that attribute is not set on node.
     *
     * @param key Key of attribute to look for.
     * @returns Attribute value or `undefined`.
     */
    getAttribute(key) {
        return this._attrs.get(key);
    }
    /**
     * Returns iterator that iterates over this node's attributes.
     *
     * Attributes are returned as arrays containing two items. First one is attribute key and second is attribute value.
     * This format is accepted by native `Map` object and also can be passed in `Node` constructor.
     */
    getAttributes() {
        return this._attrs.entries();
    }
    /**
     * Returns iterator that iterates over this node's attribute keys.
     */
    getAttributeKeys() {
        return this._attrs.keys();
    }
    /**
     * Converts `Node` to plain object and returns it.
     *
     * @returns `Node` converted to plain object.
     */
    toJSON() {
        const json = {};
        // Serializes attributes to the object.
        // attributes = { a: 'foo', b: 1, c: true }.
        if (this._attrs.size) {
            json.attributes = Array.from(this._attrs).reduce((result, attr) => {
                result[attr[0]] = attr[1];
                return result;
            }, {});
        }
        return json;
    }
    /**
     * Creates a copy of this node, that is a node with exactly same attributes, and returns it.
     *
     * @internal
     * @returns Node with same attributes as this node.
     */
    _clone(_deep) {
        return new this.constructor(this._attrs);
    }
    /**
     * Removes this node from it's parent.
     *
     * @internal
     * @see module:engine/model/writer~Writer#remove
     */
    _remove() {
        this.parent._removeChildren(this.index);
    }
    /**
     * Sets attribute on the node. If attribute with the same key already is set, it's value is overwritten.
     *
     * @see module:engine/model/writer~Writer#setAttribute
     * @internal
     * @param key Key of attribute to set.
     * @param value Attribute value.
     */
    _setAttribute(key, value) {
        this._attrs.set(key, value);
    }
    /**
     * Removes all attributes from the node and sets given attributes.
     *
     * @see module:engine/model/writer~Writer#setAttributes
     * @internal
     * @param attrs Attributes to set. See {@link module:utils/tomap~toMap} for a list of accepted values.
     */
    _setAttributesTo(attrs) {
        this._attrs = toMap(attrs);
    }
    /**
     * Removes an attribute with given key from the node.
     *
     * @see module:engine/model/writer~Writer#removeAttribute
     * @internal
     * @param key Key of attribute to remove.
     * @returns `true` if the attribute was set on the element, `false` otherwise.
     */
    _removeAttribute(key) {
        return this._attrs.delete(key);
    }
    /**
     * Removes all attributes from the node.
     *
     * @see module:engine/model/writer~Writer#clearAttributes
     * @internal
     */
    _clearAttributes() {
        this._attrs.clear();
    }
}
// The magic of type inference using `is` method is centralized in `TypeCheckable` class.
// Proper overload would interfere with that.
Node.prototype.is = function (type) {
    return type === 'node' || type === 'model:node';
};
