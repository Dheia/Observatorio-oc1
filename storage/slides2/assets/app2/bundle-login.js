/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 21);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

    "use strict";
    /* harmony export (immutable) */ __webpack_exports__["b"] = __extends;
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __assign; });
    /* unused harmony export __rest */
    /* unused harmony export __decorate */
    /* unused harmony export __param */
    /* unused harmony export __metadata */
    /* unused harmony export __awaiter */
    /* unused harmony export __generator */
    /* unused harmony export __exportStar */
    /* unused harmony export __values */
    /* unused harmony export __read */
    /* harmony export (immutable) */ __webpack_exports__["c"] = __spread;
    /* unused harmony export __spreadArrays */
    /* unused harmony export __await */
    /* unused harmony export __asyncGenerator */
    /* unused harmony export __asyncDelegator */
    /* unused harmony export __asyncValues */
    /* unused harmony export __makeTemplateObject */
    /* unused harmony export __importStar */
    /* unused harmony export __importDefault */
    /*! *****************************************************************************
    Copyright (c) Microsoft Corporation. All rights reserved.
    Licensed under the Apache License, Version 2.0 (the "License"); you may not use
    this file except in compliance with the License. You may obtain a copy of the
    License at http://www.apache.org/licenses/LICENSE-2.0
    
    THIS CODE IS PROVIDED ON AN *AS IS* BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
    KIND, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED
    WARRANTIES OR CONDITIONS OF TITLE, FITNESS FOR A PARTICULAR PURPOSE,
    MERCHANTABLITY OR NON-INFRINGEMENT.
    
    See the Apache Version 2.0 License for specific language governing permissions
    and limitations under the License.
    ***************************************************************************** */
    /* global Reflect, Promise */
    
    var extendStatics = function(d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    
    function __extends(d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    }
    
    var __assign = function() {
        __assign = Object.assign || function __assign(t) {
            for (var s, i = 1, n = arguments.length; i < n; i++) {
                s = arguments[i];
                for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p)) t[p] = s[p];
            }
            return t;
        }
        return __assign.apply(this, arguments);
    }
    
    function __rest(s, e) {
        var t = {};
        for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p) && e.indexOf(p) < 0)
            t[p] = s[p];
        if (s != null && typeof Object.getOwnPropertySymbols === "function")
            for (var i = 0, p = Object.getOwnPropertySymbols(s); i < p.length; i++) {
                if (e.indexOf(p[i]) < 0 && Object.prototype.propertyIsEnumerable.call(s, p[i]))
                    t[p[i]] = s[p[i]];
            }
        return t;
    }
    
    function __decorate(decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    }
    
    function __param(paramIndex, decorator) {
        return function (target, key) { decorator(target, key, paramIndex); }
    }
    
    function __metadata(metadataKey, metadataValue) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(metadataKey, metadataValue);
    }
    
    function __awaiter(thisArg, _arguments, P, generator) {
        return new (P || (P = Promise))(function (resolve, reject) {
            function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
            function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
            function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
            step((generator = generator.apply(thisArg, _arguments || [])).next());
        });
    }
    
    function __generator(thisArg, body) {
        var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
        return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
        function verb(n) { return function (v) { return step([n, v]); }; }
        function step(op) {
            if (f) throw new TypeError("Generator is already executing.");
            while (_) try {
                if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
                if (y = 0, t) op = [op[0] & 2, t.value];
                switch (op[0]) {
                    case 0: case 1: t = op; break;
                    case 4: _.label++; return { value: op[1], done: false };
                    case 5: _.label++; y = op[1]; op = [0]; continue;
                    case 7: op = _.ops.pop(); _.trys.pop(); continue;
                    default:
                        if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                        if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                        if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                        if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                        if (t[2]) _.ops.pop();
                        _.trys.pop(); continue;
                }
                op = body.call(thisArg, _);
            } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
            if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
        }
    }
    
    function __exportStar(m, exports) {
        for (var p in m) if (!exports.hasOwnProperty(p)) exports[p] = m[p];
    }
    
    function __values(o) {
        var m = typeof Symbol === "function" && o[Symbol.iterator], i = 0;
        if (m) return m.call(o);
        return {
            next: function () {
                if (o && i >= o.length) o = void 0;
                return { value: o && o[i++], done: !o };
            }
        };
    }
    
    function __read(o, n) {
        var m = typeof Symbol === "function" && o[Symbol.iterator];
        if (!m) return o;
        var i = m.call(o), r, ar = [], e;
        try {
            while ((n === void 0 || n-- > 0) && !(r = i.next()).done) ar.push(r.value);
        }
        catch (error) { e = { error: error }; }
        finally {
            try {
                if (r && !r.done && (m = i["return"])) m.call(i);
            }
            finally { if (e) throw e.error; }
        }
        return ar;
    }
    
    function __spread() {
        for (var ar = [], i = 0; i < arguments.length; i++)
            ar = ar.concat(__read(arguments[i]));
        return ar;
    }
    
    function __spreadArrays() {
        for (var s = 0, i = 0, il = arguments.length; i < il; i++) s += arguments[i].length;
        for (var r = Array(s), k = 0, i = 0; i < il; i++)
            for (var a = arguments[i], j = 0, jl = a.length; j < jl; j++, k++)
                r[k] = a[j];
        return r;
    };
    
    function __await(v) {
        return this instanceof __await ? (this.v = v, this) : new __await(v);
    }
    
    function __asyncGenerator(thisArg, _arguments, generator) {
        if (!Symbol.asyncIterator) throw new TypeError("Symbol.asyncIterator is not defined.");
        var g = generator.apply(thisArg, _arguments || []), i, q = [];
        return i = {}, verb("next"), verb("throw"), verb("return"), i[Symbol.asyncIterator] = function () { return this; }, i;
        function verb(n) { if (g[n]) i[n] = function (v) { return new Promise(function (a, b) { q.push([n, v, a, b]) > 1 || resume(n, v); }); }; }
        function resume(n, v) { try { step(g[n](v)); } catch (e) { settle(q[0][3], e); } }
        function step(r) { r.value instanceof __await ? Promise.resolve(r.value.v).then(fulfill, reject) : settle(q[0][2], r); }
        function fulfill(value) { resume("next", value); }
        function reject(value) { resume("throw", value); }
        function settle(f, v) { if (f(v), q.shift(), q.length) resume(q[0][0], q[0][1]); }
    }
    
    function __asyncDelegator(o) {
        var i, p;
        return i = {}, verb("next"), verb("throw", function (e) { throw e; }), verb("return"), i[Symbol.iterator] = function () { return this; }, i;
        function verb(n, f) { i[n] = o[n] ? function (v) { return (p = !p) ? { value: __await(o[n](v)), done: n === "return" } : f ? f(v) : v; } : f; }
    }
    
    function __asyncValues(o) {
        if (!Symbol.asyncIterator) throw new TypeError("Symbol.asyncIterator is not defined.");
        var m = o[Symbol.asyncIterator], i;
        return m ? m.call(o) : (o = typeof __values === "function" ? __values(o) : o[Symbol.iterator](), i = {}, verb("next"), verb("throw"), verb("return"), i[Symbol.asyncIterator] = function () { return this; }, i);
        function verb(n) { i[n] = o[n] && function (v) { return new Promise(function (resolve, reject) { v = o[n](v), settle(resolve, reject, v.done, v.value); }); }; }
        function settle(resolve, reject, d, v) { Promise.resolve(v).then(function(v) { resolve({ value: v, done: d }); }, reject); }
    }
    
    function __makeTemplateObject(cooked, raw) {
        if (Object.defineProperty) { Object.defineProperty(cooked, "raw", { value: raw }); } else { cooked.raw = raw; }
        return cooked;
    };
    
    function __importStar(mod) {
        if (mod && mod.__esModule) return mod;
        var result = {};
        if (mod != null) for (var k in mod) if (Object.hasOwnProperty.call(mod, k)) result[k] = mod[k];
        result.default = mod;
        return result;
    }
    
    function __importDefault(mod) {
        return (mod && mod.__esModule) ? mod : { default: mod };
    }
    
    
    /***/ }),
    /* 1 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCFoundation; });
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var MDCFoundation = /** @class */ (function () {
        function MDCFoundation(adapter) {
            if (adapter === void 0) { adapter = {}; }
            this.adapter_ = adapter;
        }
        Object.defineProperty(MDCFoundation, "cssClasses", {
            get: function () {
                // Classes extending MDCFoundation should implement this method to return an object which exports every
                // CSS class the foundation class needs as a property. e.g. {ACTIVE: 'mdc-component--active'}
                return {};
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCFoundation, "strings", {
            get: function () {
                // Classes extending MDCFoundation should implement this method to return an object which exports all
                // semantic strings as constants. e.g. {ARIA_ROLE: 'tablist'}
                return {};
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCFoundation, "numbers", {
            get: function () {
                // Classes extending MDCFoundation should implement this method to return an object which exports all
                // of its semantic numbers as constants. e.g. {ANIMATION_DELAY_MS: 350}
                return {};
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCFoundation, "defaultAdapter", {
            get: function () {
                // Classes extending MDCFoundation may choose to implement this getter in order to provide a convenient
                // way of viewing the necessary methods of an adapter. In the future, this could also be used for adapter
                // validation.
                return {};
            },
            enumerable: true,
            configurable: true
        });
        MDCFoundation.prototype.init = function () {
            // Subclasses should override this method to perform initialization routines (registering events, etc.)
        };
        MDCFoundation.prototype.destroy = function () {
            // Subclasses should override this method to perform de-initialization routines (de-registering events, etc.)
        };
        return MDCFoundation;
    }());
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 2 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCComponent; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__foundation__ = __webpack_require__(1);
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    var MDCComponent = /** @class */ (function () {
        function MDCComponent(root, foundation) {
            var args = [];
            for (var _i = 2; _i < arguments.length; _i++) {
                args[_i - 2] = arguments[_i];
            }
            this.root_ = root;
            this.initialize.apply(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["c" /* __spread */](args));
            // Note that we initialize foundation here and not within the constructor's default param so that
            // this.root_ is defined and can be used within the foundation class.
            this.foundation_ = foundation === undefined ? this.getDefaultFoundation() : foundation;
            this.foundation_.init();
            this.initialSyncWithDOM();
        }
        MDCComponent.attachTo = function (root) {
            // Subclasses which extend MDCBase should provide an attachTo() method that takes a root element and
            // returns an instantiated component with its root set to that element. Also note that in the cases of
            // subclasses, an explicit foundation class will not have to be passed in; it will simply be initialized
            // from getDefaultFoundation().
            return new MDCComponent(root, new __WEBPACK_IMPORTED_MODULE_1__foundation__["a" /* MDCFoundation */]({}));
        };
        /* istanbul ignore next: method param only exists for typing purposes; it does not need to be unit tested */
        MDCComponent.prototype.initialize = function () {
            var _args = [];
            for (var _i = 0; _i < arguments.length; _i++) {
                _args[_i] = arguments[_i];
            }
            // Subclasses can override this to do any additional setup work that would be considered part of a
            // "constructor". Essentially, it is a hook into the parent constructor before the foundation is
            // initialized. Any additional arguments besides root and foundation will be passed in here.
        };
        MDCComponent.prototype.getDefaultFoundation = function () {
            // Subclasses must override this method to return a properly configured foundation class for the
            // component.
            throw new Error('Subclasses must override getDefaultFoundation to return a properly configured ' +
                'foundation class');
        };
        MDCComponent.prototype.initialSyncWithDOM = function () {
            // Subclasses should override this method if they need to perform work to synchronize with a host DOM
            // object. An example of this would be a form control wrapper that needs to synchronize its internal state
            // to some property or attribute of the host DOM. Please note: this is *not* the place to perform DOM
            // reads/writes that would cause layout / paint, as this is called synchronously from within the constructor.
        };
        MDCComponent.prototype.destroy = function () {
            // Subclasses may implement this method to release any resources / deregister any listeners they have
            // attached. An example of this might be deregistering a resize event from the window object.
            this.foundation_.destroy();
        };
        MDCComponent.prototype.listen = function (evtType, handler) {
            this.root_.addEventListener(evtType, handler);
        };
        MDCComponent.prototype.unlisten = function (evtType, handler) {
            this.root_.removeEventListener(evtType, handler);
        };
        /**
         * Fires a cross-browser-compatible custom event from the component root of the given type, with the given data.
         */
        MDCComponent.prototype.emit = function (evtType, evtData, shouldBubble) {
            if (shouldBubble === void 0) { shouldBubble = false; }
            var evt;
            if (typeof CustomEvent === 'function') {
                evt = new CustomEvent(evtType, {
                    bubbles: shouldBubble,
                    detail: evtData,
                });
            }
            else {
                evt = document.createEvent('CustomEvent');
                evt.initCustomEvent(evtType, shouldBubble, false, evtData);
            }
            this.root_.dispatchEvent(evt);
        };
        return MDCComponent;
    }());
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCComponent);
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 3 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
    /* harmony export (immutable) */ __webpack_exports__["supportsCssVariables"] = supportsCssVariables;
    /* harmony export (immutable) */ __webpack_exports__["applyPassive"] = applyPassive;
    /* harmony export (immutable) */ __webpack_exports__["getNormalizedEventCoords"] = getNormalizedEventCoords;
    /**
     * Stores result from supportsCssVariables to avoid redundant processing to
     * detect CSS custom variable support.
     */
    var supportsCssVariables_;
    /**
     * Stores result from applyPassive to avoid redundant processing to detect
     * passive event listener support.
     */
    var supportsPassive_;
    function detectEdgePseudoVarBug(windowObj) {
        // Detect versions of Edge with buggy var() support
        // See: https://developer.microsoft.com/en-us/microsoft-edge/platform/issues/11495448/
        var document = windowObj.document;
        var node = document.createElement('div');
        node.className = 'mdc-ripple-surface--test-edge-var-bug';
        document.body.appendChild(node);
        // The bug exists if ::before style ends up propagating to the parent element.
        // Additionally, getComputedStyle returns null in iframes with display: "none" in Firefox,
        // but Firefox is known to support CSS custom properties correctly.
        // See: https://bugzilla.mozilla.org/show_bug.cgi?id=548397
        var computedStyle = windowObj.getComputedStyle(node);
        var hasPseudoVarBug = computedStyle !== null && computedStyle.borderTopStyle === 'solid';
        node.remove();
        return hasPseudoVarBug;
    }
    function supportsCssVariables(windowObj, forceRefresh) {
        if (forceRefresh === void 0) { forceRefresh = false; }
        var CSS = windowObj.CSS;
        var supportsCssVars = supportsCssVariables_;
        if (typeof supportsCssVariables_ === 'boolean' && !forceRefresh) {
            return supportsCssVariables_;
        }
        var supportsFunctionPresent = CSS && typeof CSS.supports === 'function';
        if (!supportsFunctionPresent) {
            return false;
        }
        var explicitlySupportsCssVars = CSS.supports('--css-vars', 'yes');
        // See: https://bugs.webkit.org/show_bug.cgi?id=154669
        // See: README section on Safari
        var weAreFeatureDetectingSafari10plus = (CSS.supports('(--css-vars: yes)') &&
            CSS.supports('color', '#00000000'));
        if (explicitlySupportsCssVars || weAreFeatureDetectingSafari10plus) {
            supportsCssVars = !detectEdgePseudoVarBug(windowObj);
        }
        else {
            supportsCssVars = false;
        }
        if (!forceRefresh) {
            supportsCssVariables_ = supportsCssVars;
        }
        return supportsCssVars;
    }
    /**
     * Determine whether the current browser supports passive event listeners, and
     * if so, use them.
     */
    function applyPassive(globalObj, forceRefresh) {
        if (globalObj === void 0) { globalObj = window; }
        if (forceRefresh === void 0) { forceRefresh = false; }
        if (supportsPassive_ === undefined || forceRefresh) {
            var isSupported_1 = false;
            try {
                globalObj.document.addEventListener('test', function () { return undefined; }, {
                    get passive() {
                        isSupported_1 = true;
                        return isSupported_1;
                    },
                });
            }
            catch (e) {
            } // tslint:disable-line:no-empty cannot throw error due to tests. tslint also disables console.log.
            supportsPassive_ = isSupported_1;
        }
        return supportsPassive_ ? { passive: true } : false;
    }
    function getNormalizedEventCoords(evt, pageOffset, clientRect) {
        if (!evt) {
            return { x: 0, y: 0 };
        }
        var x = pageOffset.x, y = pageOffset.y;
        var documentX = x + clientRect.left;
        var documentY = y + clientRect.top;
        var normalizedX;
        var normalizedY;
        // Determine touch point relative to the ripple container.
        if (evt.type === 'touchstart') {
            var touchEvent = evt;
            normalizedX = touchEvent.changedTouches[0].pageX - documentX;
            normalizedY = touchEvent.changedTouches[0].pageY - documentY;
        }
        else {
            var mouseEvent = evt;
            normalizedX = mouseEvent.pageX - documentX;
            normalizedY = mouseEvent.pageY - documentY;
        }
        return { x: normalizedX, y: normalizedY };
    }
    //# sourceMappingURL=util.js.map
    
    /***/ }),
    /* 4 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCRippleFoundation; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_foundation__ = __webpack_require__(1);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constants__ = __webpack_require__(47);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__util__ = __webpack_require__(3);
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    
    // Activation events registered on the root element of each instance for activation
    var ACTIVATION_EVENT_TYPES = [
        'touchstart', 'pointerdown', 'mousedown', 'keydown',
    ];
    // Deactivation events registered on documentElement when a pointer-related down event occurs
    var POINTER_DEACTIVATION_EVENT_TYPES = [
        'touchend', 'pointerup', 'mouseup', 'contextmenu',
    ];
    // simultaneous nested activations
    var activatedTargets = [];
    var MDCRippleFoundation = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCRippleFoundation, _super);
        function MDCRippleFoundation(adapter) {
            var _this = _super.call(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, MDCRippleFoundation.defaultAdapter, adapter)) || this;
            _this.activationAnimationHasEnded_ = false;
            _this.activationTimer_ = 0;
            _this.fgDeactivationRemovalTimer_ = 0;
            _this.fgScale_ = '0';
            _this.frame_ = { width: 0, height: 0 };
            _this.initialSize_ = 0;
            _this.layoutFrame_ = 0;
            _this.maxRadius_ = 0;
            _this.unboundedCoords_ = { left: 0, top: 0 };
            _this.activationState_ = _this.defaultActivationState_();
            _this.activationTimerCallback_ = function () {
                _this.activationAnimationHasEnded_ = true;
                _this.runDeactivationUXLogicIfReady_();
            };
            _this.activateHandler_ = function (e) { return _this.activate_(e); };
            _this.deactivateHandler_ = function () { return _this.deactivate_(); };
            _this.focusHandler_ = function () { return _this.handleFocus(); };
            _this.blurHandler_ = function () { return _this.handleBlur(); };
            _this.resizeHandler_ = function () { return _this.layout(); };
            return _this;
        }
        Object.defineProperty(MDCRippleFoundation, "cssClasses", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCRippleFoundation, "strings", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["c" /* strings */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCRippleFoundation, "numbers", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["b" /* numbers */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCRippleFoundation, "defaultAdapter", {
            get: function () {
                return {
                    addClass: function () { return undefined; },
                    browserSupportsCssVars: function () { return true; },
                    computeBoundingRect: function () { return ({ top: 0, right: 0, bottom: 0, left: 0, width: 0, height: 0 }); },
                    containsEventTarget: function () { return true; },
                    deregisterDocumentInteractionHandler: function () { return undefined; },
                    deregisterInteractionHandler: function () { return undefined; },
                    deregisterResizeHandler: function () { return undefined; },
                    getWindowPageOffset: function () { return ({ x: 0, y: 0 }); },
                    isSurfaceActive: function () { return true; },
                    isSurfaceDisabled: function () { return true; },
                    isUnbounded: function () { return true; },
                    registerDocumentInteractionHandler: function () { return undefined; },
                    registerInteractionHandler: function () { return undefined; },
                    registerResizeHandler: function () { return undefined; },
                    removeClass: function () { return undefined; },
                    updateCssVariable: function () { return undefined; },
                };
            },
            enumerable: true,
            configurable: true
        });
        MDCRippleFoundation.prototype.init = function () {
            var _this = this;
            var supportsPressRipple = this.supportsPressRipple_();
            this.registerRootHandlers_(supportsPressRipple);
            if (supportsPressRipple) {
                var _a = MDCRippleFoundation.cssClasses, ROOT_1 = _a.ROOT, UNBOUNDED_1 = _a.UNBOUNDED;
                requestAnimationFrame(function () {
                    _this.adapter_.addClass(ROOT_1);
                    if (_this.adapter_.isUnbounded()) {
                        _this.adapter_.addClass(UNBOUNDED_1);
                        // Unbounded ripples need layout logic applied immediately to set coordinates for both shade and ripple
                        _this.layoutInternal_();
                    }
                });
            }
        };
        MDCRippleFoundation.prototype.destroy = function () {
            var _this = this;
            if (this.supportsPressRipple_()) {
                if (this.activationTimer_) {
                    clearTimeout(this.activationTimer_);
                    this.activationTimer_ = 0;
                    this.adapter_.removeClass(MDCRippleFoundation.cssClasses.FG_ACTIVATION);
                }
                if (this.fgDeactivationRemovalTimer_) {
                    clearTimeout(this.fgDeactivationRemovalTimer_);
                    this.fgDeactivationRemovalTimer_ = 0;
                    this.adapter_.removeClass(MDCRippleFoundation.cssClasses.FG_DEACTIVATION);
                }
                var _a = MDCRippleFoundation.cssClasses, ROOT_2 = _a.ROOT, UNBOUNDED_2 = _a.UNBOUNDED;
                requestAnimationFrame(function () {
                    _this.adapter_.removeClass(ROOT_2);
                    _this.adapter_.removeClass(UNBOUNDED_2);
                    _this.removeCssVars_();
                });
            }
            this.deregisterRootHandlers_();
            this.deregisterDeactivationHandlers_();
        };
        /**
         * @param evt Optional event containing position information.
         */
        MDCRippleFoundation.prototype.activate = function (evt) {
            this.activate_(evt);
        };
        MDCRippleFoundation.prototype.deactivate = function () {
            this.deactivate_();
        };
        MDCRippleFoundation.prototype.layout = function () {
            var _this = this;
            if (this.layoutFrame_) {
                cancelAnimationFrame(this.layoutFrame_);
            }
            this.layoutFrame_ = requestAnimationFrame(function () {
                _this.layoutInternal_();
                _this.layoutFrame_ = 0;
            });
        };
        MDCRippleFoundation.prototype.setUnbounded = function (unbounded) {
            var UNBOUNDED = MDCRippleFoundation.cssClasses.UNBOUNDED;
            if (unbounded) {
                this.adapter_.addClass(UNBOUNDED);
            }
            else {
                this.adapter_.removeClass(UNBOUNDED);
            }
        };
        MDCRippleFoundation.prototype.handleFocus = function () {
            var _this = this;
            requestAnimationFrame(function () {
                return _this.adapter_.addClass(MDCRippleFoundation.cssClasses.BG_FOCUSED);
            });
        };
        MDCRippleFoundation.prototype.handleBlur = function () {
            var _this = this;
            requestAnimationFrame(function () {
                return _this.adapter_.removeClass(MDCRippleFoundation.cssClasses.BG_FOCUSED);
            });
        };
        /**
         * We compute this property so that we are not querying information about the client
         * until the point in time where the foundation requests it. This prevents scenarios where
         * client-side feature-detection may happen too early, such as when components are rendered on the server
         * and then initialized at mount time on the client.
         */
        MDCRippleFoundation.prototype.supportsPressRipple_ = function () {
            return this.adapter_.browserSupportsCssVars();
        };
        MDCRippleFoundation.prototype.defaultActivationState_ = function () {
            return {
                activationEvent: undefined,
                hasDeactivationUXRun: false,
                isActivated: false,
                isProgrammatic: false,
                wasActivatedByPointer: false,
                wasElementMadeActive: false,
            };
        };
        /**
         * supportsPressRipple Passed from init to save a redundant function call
         */
        MDCRippleFoundation.prototype.registerRootHandlers_ = function (supportsPressRipple) {
            var _this = this;
            if (supportsPressRipple) {
                ACTIVATION_EVENT_TYPES.forEach(function (evtType) {
                    _this.adapter_.registerInteractionHandler(evtType, _this.activateHandler_);
                });
                if (this.adapter_.isUnbounded()) {
                    this.adapter_.registerResizeHandler(this.resizeHandler_);
                }
            }
            this.adapter_.registerInteractionHandler('focus', this.focusHandler_);
            this.adapter_.registerInteractionHandler('blur', this.blurHandler_);
        };
        MDCRippleFoundation.prototype.registerDeactivationHandlers_ = function (evt) {
            var _this = this;
            if (evt.type === 'keydown') {
                this.adapter_.registerInteractionHandler('keyup', this.deactivateHandler_);
            }
            else {
                POINTER_DEACTIVATION_EVENT_TYPES.forEach(function (evtType) {
                    _this.adapter_.registerDocumentInteractionHandler(evtType, _this.deactivateHandler_);
                });
            }
        };
        MDCRippleFoundation.prototype.deregisterRootHandlers_ = function () {
            var _this = this;
            ACTIVATION_EVENT_TYPES.forEach(function (evtType) {
                _this.adapter_.deregisterInteractionHandler(evtType, _this.activateHandler_);
            });
            this.adapter_.deregisterInteractionHandler('focus', this.focusHandler_);
            this.adapter_.deregisterInteractionHandler('blur', this.blurHandler_);
            if (this.adapter_.isUnbounded()) {
                this.adapter_.deregisterResizeHandler(this.resizeHandler_);
            }
        };
        MDCRippleFoundation.prototype.deregisterDeactivationHandlers_ = function () {
            var _this = this;
            this.adapter_.deregisterInteractionHandler('keyup', this.deactivateHandler_);
            POINTER_DEACTIVATION_EVENT_TYPES.forEach(function (evtType) {
                _this.adapter_.deregisterDocumentInteractionHandler(evtType, _this.deactivateHandler_);
            });
        };
        MDCRippleFoundation.prototype.removeCssVars_ = function () {
            var _this = this;
            var rippleStrings = MDCRippleFoundation.strings;
            var keys = Object.keys(rippleStrings);
            keys.forEach(function (key) {
                if (key.indexOf('VAR_') === 0) {
                    _this.adapter_.updateCssVariable(rippleStrings[key], null);
                }
            });
        };
        MDCRippleFoundation.prototype.activate_ = function (evt) {
            var _this = this;
            if (this.adapter_.isSurfaceDisabled()) {
                return;
            }
            var activationState = this.activationState_;
            if (activationState.isActivated) {
                return;
            }
            // Avoid reacting to follow-on events fired by touch device after an already-processed user interaction
            var previousActivationEvent = this.previousActivationEvent_;
            var isSameInteraction = previousActivationEvent && evt !== undefined && previousActivationEvent.type !== evt.type;
            if (isSameInteraction) {
                return;
            }
            activationState.isActivated = true;
            activationState.isProgrammatic = evt === undefined;
            activationState.activationEvent = evt;
            activationState.wasActivatedByPointer = activationState.isProgrammatic ? false : evt !== undefined && (evt.type === 'mousedown' || evt.type === 'touchstart' || evt.type === 'pointerdown');
            var hasActivatedChild = evt !== undefined && activatedTargets.length > 0 && activatedTargets.some(function (target) { return _this.adapter_.containsEventTarget(target); });
            if (hasActivatedChild) {
                // Immediately reset activation state, while preserving logic that prevents touch follow-on events
                this.resetActivationState_();
                return;
            }
            if (evt !== undefined) {
                activatedTargets.push(evt.target);
                this.registerDeactivationHandlers_(evt);
            }
            activationState.wasElementMadeActive = this.checkElementMadeActive_(evt);
            if (activationState.wasElementMadeActive) {
                this.animateActivation_();
            }
            requestAnimationFrame(function () {
                // Reset array on next frame after the current event has had a chance to bubble to prevent ancestor ripples
                activatedTargets = [];
                if (!activationState.wasElementMadeActive
                    && evt !== undefined
                    && (evt.key === ' ' || evt.keyCode === 32)) {
                    // If space was pressed, try again within an rAF call to detect :active, because different UAs report
                    // active states inconsistently when they're called within event handling code:
                    // - https://bugs.chromium.org/p/chromium/issues/detail?id=635971
                    // - https://bugzilla.mozilla.org/show_bug.cgi?id=1293741
                    // We try first outside rAF to support Edge, which does not exhibit this problem, but will crash if a CSS
                    // variable is set within a rAF callback for a submit button interaction (#2241).
                    activationState.wasElementMadeActive = _this.checkElementMadeActive_(evt);
                    if (activationState.wasElementMadeActive) {
                        _this.animateActivation_();
                    }
                }
                if (!activationState.wasElementMadeActive) {
                    // Reset activation state immediately if element was not made active.
                    _this.activationState_ = _this.defaultActivationState_();
                }
            });
        };
        MDCRippleFoundation.prototype.checkElementMadeActive_ = function (evt) {
            return (evt !== undefined && evt.type === 'keydown') ? this.adapter_.isSurfaceActive() : true;
        };
        MDCRippleFoundation.prototype.animateActivation_ = function () {
            var _this = this;
            var _a = MDCRippleFoundation.strings, VAR_FG_TRANSLATE_START = _a.VAR_FG_TRANSLATE_START, VAR_FG_TRANSLATE_END = _a.VAR_FG_TRANSLATE_END;
            var _b = MDCRippleFoundation.cssClasses, FG_DEACTIVATION = _b.FG_DEACTIVATION, FG_ACTIVATION = _b.FG_ACTIVATION;
            var DEACTIVATION_TIMEOUT_MS = MDCRippleFoundation.numbers.DEACTIVATION_TIMEOUT_MS;
            this.layoutInternal_();
            var translateStart = '';
            var translateEnd = '';
            if (!this.adapter_.isUnbounded()) {
                var _c = this.getFgTranslationCoordinates_(), startPoint = _c.startPoint, endPoint = _c.endPoint;
                translateStart = startPoint.x + "px, " + startPoint.y + "px";
                translateEnd = endPoint.x + "px, " + endPoint.y + "px";
            }
            this.adapter_.updateCssVariable(VAR_FG_TRANSLATE_START, translateStart);
            this.adapter_.updateCssVariable(VAR_FG_TRANSLATE_END, translateEnd);
            // Cancel any ongoing activation/deactivation animations
            clearTimeout(this.activationTimer_);
            clearTimeout(this.fgDeactivationRemovalTimer_);
            this.rmBoundedActivationClasses_();
            this.adapter_.removeClass(FG_DEACTIVATION);
            // Force layout in order to re-trigger the animation.
            this.adapter_.computeBoundingRect();
            this.adapter_.addClass(FG_ACTIVATION);
            this.activationTimer_ = setTimeout(function () { return _this.activationTimerCallback_(); }, DEACTIVATION_TIMEOUT_MS);
        };
        MDCRippleFoundation.prototype.getFgTranslationCoordinates_ = function () {
            var _a = this.activationState_, activationEvent = _a.activationEvent, wasActivatedByPointer = _a.wasActivatedByPointer;
            var startPoint;
            if (wasActivatedByPointer) {
                startPoint = Object(__WEBPACK_IMPORTED_MODULE_3__util__["getNormalizedEventCoords"])(activationEvent, this.adapter_.getWindowPageOffset(), this.adapter_.computeBoundingRect());
            }
            else {
                startPoint = {
                    x: this.frame_.width / 2,
                    y: this.frame_.height / 2,
                };
            }
            // Center the element around the start point.
            startPoint = {
                x: startPoint.x - (this.initialSize_ / 2),
                y: startPoint.y - (this.initialSize_ / 2),
            };
            var endPoint = {
                x: (this.frame_.width / 2) - (this.initialSize_ / 2),
                y: (this.frame_.height / 2) - (this.initialSize_ / 2),
            };
            return { startPoint: startPoint, endPoint: endPoint };
        };
        MDCRippleFoundation.prototype.runDeactivationUXLogicIfReady_ = function () {
            var _this = this;
            // This method is called both when a pointing device is released, and when the activation animation ends.
            // The deactivation animation should only run after both of those occur.
            var FG_DEACTIVATION = MDCRippleFoundation.cssClasses.FG_DEACTIVATION;
            var _a = this.activationState_, hasDeactivationUXRun = _a.hasDeactivationUXRun, isActivated = _a.isActivated;
            var activationHasEnded = hasDeactivationUXRun || !isActivated;
            if (activationHasEnded && this.activationAnimationHasEnded_) {
                this.rmBoundedActivationClasses_();
                this.adapter_.addClass(FG_DEACTIVATION);
                this.fgDeactivationRemovalTimer_ = setTimeout(function () {
                    _this.adapter_.removeClass(FG_DEACTIVATION);
                }, __WEBPACK_IMPORTED_MODULE_2__constants__["b" /* numbers */].FG_DEACTIVATION_MS);
            }
        };
        MDCRippleFoundation.prototype.rmBoundedActivationClasses_ = function () {
            var FG_ACTIVATION = MDCRippleFoundation.cssClasses.FG_ACTIVATION;
            this.adapter_.removeClass(FG_ACTIVATION);
            this.activationAnimationHasEnded_ = false;
            this.adapter_.computeBoundingRect();
        };
        MDCRippleFoundation.prototype.resetActivationState_ = function () {
            var _this = this;
            this.previousActivationEvent_ = this.activationState_.activationEvent;
            this.activationState_ = this.defaultActivationState_();
            // Touch devices may fire additional events for the same interaction within a short time.
            // Store the previous event until it's safe to assume that subsequent events are for new interactions.
            setTimeout(function () { return _this.previousActivationEvent_ = undefined; }, MDCRippleFoundation.numbers.TAP_DELAY_MS);
        };
        MDCRippleFoundation.prototype.deactivate_ = function () {
            var _this = this;
            var activationState = this.activationState_;
            // This can happen in scenarios such as when you have a keyup event that blurs the element.
            if (!activationState.isActivated) {
                return;
            }
            var state = __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, activationState);
            if (activationState.isProgrammatic) {
                requestAnimationFrame(function () { return _this.animateDeactivation_(state); });
                this.resetActivationState_();
            }
            else {
                this.deregisterDeactivationHandlers_();
                requestAnimationFrame(function () {
                    _this.activationState_.hasDeactivationUXRun = true;
                    _this.animateDeactivation_(state);
                    _this.resetActivationState_();
                });
            }
        };
        MDCRippleFoundation.prototype.animateDeactivation_ = function (_a) {
            var wasActivatedByPointer = _a.wasActivatedByPointer, wasElementMadeActive = _a.wasElementMadeActive;
            if (wasActivatedByPointer || wasElementMadeActive) {
                this.runDeactivationUXLogicIfReady_();
            }
        };
        MDCRippleFoundation.prototype.layoutInternal_ = function () {
            var _this = this;
            this.frame_ = this.adapter_.computeBoundingRect();
            var maxDim = Math.max(this.frame_.height, this.frame_.width);
            // Surface diameter is treated differently for unbounded vs. bounded ripples.
            // Unbounded ripple diameter is calculated smaller since the surface is expected to already be padded appropriately
            // to extend the hitbox, and the ripple is expected to meet the edges of the padded hitbox (which is typically
            // square). Bounded ripples, on the other hand, are fully expected to expand beyond the surface's longest diameter
            // (calculated based on the diagonal plus a constant padding), and are clipped at the surface's border via
            // `overflow: hidden`.
            var getBoundedRadius = function () {
                var hypotenuse = Math.sqrt(Math.pow(_this.frame_.width, 2) + Math.pow(_this.frame_.height, 2));
                return hypotenuse + MDCRippleFoundation.numbers.PADDING;
            };
            this.maxRadius_ = this.adapter_.isUnbounded() ? maxDim : getBoundedRadius();
            // Ripple is sized as a fraction of the largest dimension of the surface, then scales up using a CSS scale transform
            this.initialSize_ = Math.floor(maxDim * MDCRippleFoundation.numbers.INITIAL_ORIGIN_SCALE);
            this.fgScale_ = "" + this.maxRadius_ / this.initialSize_;
            this.updateLayoutCssVars_();
        };
        MDCRippleFoundation.prototype.updateLayoutCssVars_ = function () {
            var _a = MDCRippleFoundation.strings, VAR_FG_SIZE = _a.VAR_FG_SIZE, VAR_LEFT = _a.VAR_LEFT, VAR_TOP = _a.VAR_TOP, VAR_FG_SCALE = _a.VAR_FG_SCALE;
            this.adapter_.updateCssVariable(VAR_FG_SIZE, this.initialSize_ + "px");
            this.adapter_.updateCssVariable(VAR_FG_SCALE, this.fgScale_);
            if (this.adapter_.isUnbounded()) {
                this.unboundedCoords_ = {
                    left: Math.round((this.frame_.width / 2) - (this.initialSize_ / 2)),
                    top: Math.round((this.frame_.height / 2) - (this.initialSize_ / 2)),
                };
                this.adapter_.updateCssVariable(VAR_LEFT, this.unboundedCoords_.left + "px");
                this.adapter_.updateCssVariable(VAR_TOP, this.unboundedCoords_.top + "px");
            }
        };
        return MDCRippleFoundation;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_foundation__["a" /* MDCFoundation */]));
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCRippleFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 5 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCFloatingLabelFoundation; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_foundation__ = __webpack_require__(1);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constants__ = __webpack_require__(52);
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCFloatingLabelFoundation = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCFloatingLabelFoundation, _super);
        function MDCFloatingLabelFoundation(adapter) {
            var _this = _super.call(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, MDCFloatingLabelFoundation.defaultAdapter, adapter)) || this;
            _this.shakeAnimationEndHandler_ = function () { return _this.handleShakeAnimationEnd_(); };
            return _this;
        }
        Object.defineProperty(MDCFloatingLabelFoundation, "cssClasses", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCFloatingLabelFoundation, "defaultAdapter", {
            /**
             * See {@link MDCFloatingLabelAdapter} for typing information on parameters and return types.
             */
            get: function () {
                // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
                return {
                    addClass: function () { return undefined; },
                    removeClass: function () { return undefined; },
                    getWidth: function () { return 0; },
                    registerInteractionHandler: function () { return undefined; },
                    deregisterInteractionHandler: function () { return undefined; },
                };
                // tslint:enable:object-literal-sort-keys
            },
            enumerable: true,
            configurable: true
        });
        MDCFloatingLabelFoundation.prototype.init = function () {
            this.adapter_.registerInteractionHandler('animationend', this.shakeAnimationEndHandler_);
        };
        MDCFloatingLabelFoundation.prototype.destroy = function () {
            this.adapter_.deregisterInteractionHandler('animationend', this.shakeAnimationEndHandler_);
        };
        /**
         * Returns the width of the label element.
         */
        MDCFloatingLabelFoundation.prototype.getWidth = function () {
            return this.adapter_.getWidth();
        };
        /**
         * Styles the label to produce a shake animation to indicate an error.
         * @param shouldShake If true, adds the shake CSS class; otherwise, removes shake class.
         */
        MDCFloatingLabelFoundation.prototype.shake = function (shouldShake) {
            var LABEL_SHAKE = MDCFloatingLabelFoundation.cssClasses.LABEL_SHAKE;
            if (shouldShake) {
                this.adapter_.addClass(LABEL_SHAKE);
            }
            else {
                this.adapter_.removeClass(LABEL_SHAKE);
            }
        };
        /**
         * Styles the label to float or dock.
         * @param shouldFloat If true, adds the float CSS class; otherwise, removes float and shake classes to dock the label.
         */
        MDCFloatingLabelFoundation.prototype.float = function (shouldFloat) {
            var _a = MDCFloatingLabelFoundation.cssClasses, LABEL_FLOAT_ABOVE = _a.LABEL_FLOAT_ABOVE, LABEL_SHAKE = _a.LABEL_SHAKE;
            if (shouldFloat) {
                this.adapter_.addClass(LABEL_FLOAT_ABOVE);
            }
            else {
                this.adapter_.removeClass(LABEL_FLOAT_ABOVE);
                this.adapter_.removeClass(LABEL_SHAKE);
            }
        };
        MDCFloatingLabelFoundation.prototype.handleShakeAnimationEnd_ = function () {
            var LABEL_SHAKE = MDCFloatingLabelFoundation.cssClasses.LABEL_SHAKE;
            this.adapter_.removeClass(LABEL_SHAKE);
        };
        return MDCFloatingLabelFoundation;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_foundation__["a" /* MDCFoundation */]));
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCFloatingLabelFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 6 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__component__ = __webpack_require__(62);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldIcon", function() { return __WEBPACK_IMPORTED_MODULE_0__component__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__foundation__ = __webpack_require__(20);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldIconFoundation", function() { return __WEBPACK_IMPORTED_MODULE_1__foundation__["a"]; });
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 7 */
    /***/ (function(module, exports) {
    
    var g;
    
    // This works in non-strict mode
    g = (function() {
        return this;
    })();
    
    try {
        // This works if eval is allowed (see CSP)
        g = g || Function("return this")() || (1,eval)("this");
    } catch(e) {
        // This works if the window reference is available
        if(typeof window === "object")
            g = window;
    }
    
    // g can still be undefined, but nothing to do about it...
    // We return undefined, instead of nothing here, so it's
    // easier to handle this case. if(!global) { ...}
    
    module.exports = g;
    
    
    /***/ }),
    /* 8 */
    /***/ (function(module, exports) {
    
    var ENTITIES = [['Aacute', [193]], ['aacute', [225]], ['Abreve', [258]], ['abreve', [259]], ['ac', [8766]], ['acd', [8767]], ['acE', [8766, 819]], ['Acirc', [194]], ['acirc', [226]], ['acute', [180]], ['Acy', [1040]], ['acy', [1072]], ['AElig', [198]], ['aelig', [230]], ['af', [8289]], ['Afr', [120068]], ['afr', [120094]], ['Agrave', [192]], ['agrave', [224]], ['alefsym', [8501]], ['aleph', [8501]], ['Alpha', [913]], ['alpha', [945]], ['Amacr', [256]], ['amacr', [257]], ['amalg', [10815]], ['amp', [38]], ['AMP', [38]], ['andand', [10837]], ['And', [10835]], ['and', [8743]], ['andd', [10844]], ['andslope', [10840]], ['andv', [10842]], ['ang', [8736]], ['ange', [10660]], ['angle', [8736]], ['angmsdaa', [10664]], ['angmsdab', [10665]], ['angmsdac', [10666]], ['angmsdad', [10667]], ['angmsdae', [10668]], ['angmsdaf', [10669]], ['angmsdag', [10670]], ['angmsdah', [10671]], ['angmsd', [8737]], ['angrt', [8735]], ['angrtvb', [8894]], ['angrtvbd', [10653]], ['angsph', [8738]], ['angst', [197]], ['angzarr', [9084]], ['Aogon', [260]], ['aogon', [261]], ['Aopf', [120120]], ['aopf', [120146]], ['apacir', [10863]], ['ap', [8776]], ['apE', [10864]], ['ape', [8778]], ['apid', [8779]], ['apos', [39]], ['ApplyFunction', [8289]], ['approx', [8776]], ['approxeq', [8778]], ['Aring', [197]], ['aring', [229]], ['Ascr', [119964]], ['ascr', [119990]], ['Assign', [8788]], ['ast', [42]], ['asymp', [8776]], ['asympeq', [8781]], ['Atilde', [195]], ['atilde', [227]], ['Auml', [196]], ['auml', [228]], ['awconint', [8755]], ['awint', [10769]], ['backcong', [8780]], ['backepsilon', [1014]], ['backprime', [8245]], ['backsim', [8765]], ['backsimeq', [8909]], ['Backslash', [8726]], ['Barv', [10983]], ['barvee', [8893]], ['barwed', [8965]], ['Barwed', [8966]], ['barwedge', [8965]], ['bbrk', [9141]], ['bbrktbrk', [9142]], ['bcong', [8780]], ['Bcy', [1041]], ['bcy', [1073]], ['bdquo', [8222]], ['becaus', [8757]], ['because', [8757]], ['Because', [8757]], ['bemptyv', [10672]], ['bepsi', [1014]], ['bernou', [8492]], ['Bernoullis', [8492]], ['Beta', [914]], ['beta', [946]], ['beth', [8502]], ['between', [8812]], ['Bfr', [120069]], ['bfr', [120095]], ['bigcap', [8898]], ['bigcirc', [9711]], ['bigcup', [8899]], ['bigodot', [10752]], ['bigoplus', [10753]], ['bigotimes', [10754]], ['bigsqcup', [10758]], ['bigstar', [9733]], ['bigtriangledown', [9661]], ['bigtriangleup', [9651]], ['biguplus', [10756]], ['bigvee', [8897]], ['bigwedge', [8896]], ['bkarow', [10509]], ['blacklozenge', [10731]], ['blacksquare', [9642]], ['blacktriangle', [9652]], ['blacktriangledown', [9662]], ['blacktriangleleft', [9666]], ['blacktriangleright', [9656]], ['blank', [9251]], ['blk12', [9618]], ['blk14', [9617]], ['blk34', [9619]], ['block', [9608]], ['bne', [61, 8421]], ['bnequiv', [8801, 8421]], ['bNot', [10989]], ['bnot', [8976]], ['Bopf', [120121]], ['bopf', [120147]], ['bot', [8869]], ['bottom', [8869]], ['bowtie', [8904]], ['boxbox', [10697]], ['boxdl', [9488]], ['boxdL', [9557]], ['boxDl', [9558]], ['boxDL', [9559]], ['boxdr', [9484]], ['boxdR', [9554]], ['boxDr', [9555]], ['boxDR', [9556]], ['boxh', [9472]], ['boxH', [9552]], ['boxhd', [9516]], ['boxHd', [9572]], ['boxhD', [9573]], ['boxHD', [9574]], ['boxhu', [9524]], ['boxHu', [9575]], ['boxhU', [9576]], ['boxHU', [9577]], ['boxminus', [8863]], ['boxplus', [8862]], ['boxtimes', [8864]], ['boxul', [9496]], ['boxuL', [9563]], ['boxUl', [9564]], ['boxUL', [9565]], ['boxur', [9492]], ['boxuR', [9560]], ['boxUr', [9561]], ['boxUR', [9562]], ['boxv', [9474]], ['boxV', [9553]], ['boxvh', [9532]], ['boxvH', [9578]], ['boxVh', [9579]], ['boxVH', [9580]], ['boxvl', [9508]], ['boxvL', [9569]], ['boxVl', [9570]], ['boxVL', [9571]], ['boxvr', [9500]], ['boxvR', [9566]], ['boxVr', [9567]], ['boxVR', [9568]], ['bprime', [8245]], ['breve', [728]], ['Breve', [728]], ['brvbar', [166]], ['bscr', [119991]], ['Bscr', [8492]], ['bsemi', [8271]], ['bsim', [8765]], ['bsime', [8909]], ['bsolb', [10693]], ['bsol', [92]], ['bsolhsub', [10184]], ['bull', [8226]], ['bullet', [8226]], ['bump', [8782]], ['bumpE', [10926]], ['bumpe', [8783]], ['Bumpeq', [8782]], ['bumpeq', [8783]], ['Cacute', [262]], ['cacute', [263]], ['capand', [10820]], ['capbrcup', [10825]], ['capcap', [10827]], ['cap', [8745]], ['Cap', [8914]], ['capcup', [10823]], ['capdot', [10816]], ['CapitalDifferentialD', [8517]], ['caps', [8745, 65024]], ['caret', [8257]], ['caron', [711]], ['Cayleys', [8493]], ['ccaps', [10829]], ['Ccaron', [268]], ['ccaron', [269]], ['Ccedil', [199]], ['ccedil', [231]], ['Ccirc', [264]], ['ccirc', [265]], ['Cconint', [8752]], ['ccups', [10828]], ['ccupssm', [10832]], ['Cdot', [266]], ['cdot', [267]], ['cedil', [184]], ['Cedilla', [184]], ['cemptyv', [10674]], ['cent', [162]], ['centerdot', [183]], ['CenterDot', [183]], ['cfr', [120096]], ['Cfr', [8493]], ['CHcy', [1063]], ['chcy', [1095]], ['check', [10003]], ['checkmark', [10003]], ['Chi', [935]], ['chi', [967]], ['circ', [710]], ['circeq', [8791]], ['circlearrowleft', [8634]], ['circlearrowright', [8635]], ['circledast', [8859]], ['circledcirc', [8858]], ['circleddash', [8861]], ['CircleDot', [8857]], ['circledR', [174]], ['circledS', [9416]], ['CircleMinus', [8854]], ['CirclePlus', [8853]], ['CircleTimes', [8855]], ['cir', [9675]], ['cirE', [10691]], ['cire', [8791]], ['cirfnint', [10768]], ['cirmid', [10991]], ['cirscir', [10690]], ['ClockwiseContourIntegral', [8754]], ['clubs', [9827]], ['clubsuit', [9827]], ['colon', [58]], ['Colon', [8759]], ['Colone', [10868]], ['colone', [8788]], ['coloneq', [8788]], ['comma', [44]], ['commat', [64]], ['comp', [8705]], ['compfn', [8728]], ['complement', [8705]], ['complexes', [8450]], ['cong', [8773]], ['congdot', [10861]], ['Congruent', [8801]], ['conint', [8750]], ['Conint', [8751]], ['ContourIntegral', [8750]], ['copf', [120148]], ['Copf', [8450]], ['coprod', [8720]], ['Coproduct', [8720]], ['copy', [169]], ['COPY', [169]], ['copysr', [8471]], ['CounterClockwiseContourIntegral', [8755]], ['crarr', [8629]], ['cross', [10007]], ['Cross', [10799]], ['Cscr', [119966]], ['cscr', [119992]], ['csub', [10959]], ['csube', [10961]], ['csup', [10960]], ['csupe', [10962]], ['ctdot', [8943]], ['cudarrl', [10552]], ['cudarrr', [10549]], ['cuepr', [8926]], ['cuesc', [8927]], ['cularr', [8630]], ['cularrp', [10557]], ['cupbrcap', [10824]], ['cupcap', [10822]], ['CupCap', [8781]], ['cup', [8746]], ['Cup', [8915]], ['cupcup', [10826]], ['cupdot', [8845]], ['cupor', [10821]], ['cups', [8746, 65024]], ['curarr', [8631]], ['curarrm', [10556]], ['curlyeqprec', [8926]], ['curlyeqsucc', [8927]], ['curlyvee', [8910]], ['curlywedge', [8911]], ['curren', [164]], ['curvearrowleft', [8630]], ['curvearrowright', [8631]], ['cuvee', [8910]], ['cuwed', [8911]], ['cwconint', [8754]], ['cwint', [8753]], ['cylcty', [9005]], ['dagger', [8224]], ['Dagger', [8225]], ['daleth', [8504]], ['darr', [8595]], ['Darr', [8609]], ['dArr', [8659]], ['dash', [8208]], ['Dashv', [10980]], ['dashv', [8867]], ['dbkarow', [10511]], ['dblac', [733]], ['Dcaron', [270]], ['dcaron', [271]], ['Dcy', [1044]], ['dcy', [1076]], ['ddagger', [8225]], ['ddarr', [8650]], ['DD', [8517]], ['dd', [8518]], ['DDotrahd', [10513]], ['ddotseq', [10871]], ['deg', [176]], ['Del', [8711]], ['Delta', [916]], ['delta', [948]], ['demptyv', [10673]], ['dfisht', [10623]], ['Dfr', [120071]], ['dfr', [120097]], ['dHar', [10597]], ['dharl', [8643]], ['dharr', [8642]], ['DiacriticalAcute', [180]], ['DiacriticalDot', [729]], ['DiacriticalDoubleAcute', [733]], ['DiacriticalGrave', [96]], ['DiacriticalTilde', [732]], ['diam', [8900]], ['diamond', [8900]], ['Diamond', [8900]], ['diamondsuit', [9830]], ['diams', [9830]], ['die', [168]], ['DifferentialD', [8518]], ['digamma', [989]], ['disin', [8946]], ['div', [247]], ['divide', [247]], ['divideontimes', [8903]], ['divonx', [8903]], ['DJcy', [1026]], ['djcy', [1106]], ['dlcorn', [8990]], ['dlcrop', [8973]], ['dollar', [36]], ['Dopf', [120123]], ['dopf', [120149]], ['Dot', [168]], ['dot', [729]], ['DotDot', [8412]], ['doteq', [8784]], ['doteqdot', [8785]], ['DotEqual', [8784]], ['dotminus', [8760]], ['dotplus', [8724]], ['dotsquare', [8865]], ['doublebarwedge', [8966]], ['DoubleContourIntegral', [8751]], ['DoubleDot', [168]], ['DoubleDownArrow', [8659]], ['DoubleLeftArrow', [8656]], ['DoubleLeftRightArrow', [8660]], ['DoubleLeftTee', [10980]], ['DoubleLongLeftArrow', [10232]], ['DoubleLongLeftRightArrow', [10234]], ['DoubleLongRightArrow', [10233]], ['DoubleRightArrow', [8658]], ['DoubleRightTee', [8872]], ['DoubleUpArrow', [8657]], ['DoubleUpDownArrow', [8661]], ['DoubleVerticalBar', [8741]], ['DownArrowBar', [10515]], ['downarrow', [8595]], ['DownArrow', [8595]], ['Downarrow', [8659]], ['DownArrowUpArrow', [8693]], ['DownBreve', [785]], ['downdownarrows', [8650]], ['downharpoonleft', [8643]], ['downharpoonright', [8642]], ['DownLeftRightVector', [10576]], ['DownLeftTeeVector', [10590]], ['DownLeftVectorBar', [10582]], ['DownLeftVector', [8637]], ['DownRightTeeVector', [10591]], ['DownRightVectorBar', [10583]], ['DownRightVector', [8641]], ['DownTeeArrow', [8615]], ['DownTee', [8868]], ['drbkarow', [10512]], ['drcorn', [8991]], ['drcrop', [8972]], ['Dscr', [119967]], ['dscr', [119993]], ['DScy', [1029]], ['dscy', [1109]], ['dsol', [10742]], ['Dstrok', [272]], ['dstrok', [273]], ['dtdot', [8945]], ['dtri', [9663]], ['dtrif', [9662]], ['duarr', [8693]], ['duhar', [10607]], ['dwangle', [10662]], ['DZcy', [1039]], ['dzcy', [1119]], ['dzigrarr', [10239]], ['Eacute', [201]], ['eacute', [233]], ['easter', [10862]], ['Ecaron', [282]], ['ecaron', [283]], ['Ecirc', [202]], ['ecirc', [234]], ['ecir', [8790]], ['ecolon', [8789]], ['Ecy', [1069]], ['ecy', [1101]], ['eDDot', [10871]], ['Edot', [278]], ['edot', [279]], ['eDot', [8785]], ['ee', [8519]], ['efDot', [8786]], ['Efr', [120072]], ['efr', [120098]], ['eg', [10906]], ['Egrave', [200]], ['egrave', [232]], ['egs', [10902]], ['egsdot', [10904]], ['el', [10905]], ['Element', [8712]], ['elinters', [9191]], ['ell', [8467]], ['els', [10901]], ['elsdot', [10903]], ['Emacr', [274]], ['emacr', [275]], ['empty', [8709]], ['emptyset', [8709]], ['EmptySmallSquare', [9723]], ['emptyv', [8709]], ['EmptyVerySmallSquare', [9643]], ['emsp13', [8196]], ['emsp14', [8197]], ['emsp', [8195]], ['ENG', [330]], ['eng', [331]], ['ensp', [8194]], ['Eogon', [280]], ['eogon', [281]], ['Eopf', [120124]], ['eopf', [120150]], ['epar', [8917]], ['eparsl', [10723]], ['eplus', [10865]], ['epsi', [949]], ['Epsilon', [917]], ['epsilon', [949]], ['epsiv', [1013]], ['eqcirc', [8790]], ['eqcolon', [8789]], ['eqsim', [8770]], ['eqslantgtr', [10902]], ['eqslantless', [10901]], ['Equal', [10869]], ['equals', [61]], ['EqualTilde', [8770]], ['equest', [8799]], ['Equilibrium', [8652]], ['equiv', [8801]], ['equivDD', [10872]], ['eqvparsl', [10725]], ['erarr', [10609]], ['erDot', [8787]], ['escr', [8495]], ['Escr', [8496]], ['esdot', [8784]], ['Esim', [10867]], ['esim', [8770]], ['Eta', [919]], ['eta', [951]], ['ETH', [208]], ['eth', [240]], ['Euml', [203]], ['euml', [235]], ['euro', [8364]], ['excl', [33]], ['exist', [8707]], ['Exists', [8707]], ['expectation', [8496]], ['exponentiale', [8519]], ['ExponentialE', [8519]], ['fallingdotseq', [8786]], ['Fcy', [1060]], ['fcy', [1092]], ['female', [9792]], ['ffilig', [64259]], ['fflig', [64256]], ['ffllig', [64260]], ['Ffr', [120073]], ['ffr', [120099]], ['filig', [64257]], ['FilledSmallSquare', [9724]], ['FilledVerySmallSquare', [9642]], ['fjlig', [102, 106]], ['flat', [9837]], ['fllig', [64258]], ['fltns', [9649]], ['fnof', [402]], ['Fopf', [120125]], ['fopf', [120151]], ['forall', [8704]], ['ForAll', [8704]], ['fork', [8916]], ['forkv', [10969]], ['Fouriertrf', [8497]], ['fpartint', [10765]], ['frac12', [189]], ['frac13', [8531]], ['frac14', [188]], ['frac15', [8533]], ['frac16', [8537]], ['frac18', [8539]], ['frac23', [8532]], ['frac25', [8534]], ['frac34', [190]], ['frac35', [8535]], ['frac38', [8540]], ['frac45', [8536]], ['frac56', [8538]], ['frac58', [8541]], ['frac78', [8542]], ['frasl', [8260]], ['frown', [8994]], ['fscr', [119995]], ['Fscr', [8497]], ['gacute', [501]], ['Gamma', [915]], ['gamma', [947]], ['Gammad', [988]], ['gammad', [989]], ['gap', [10886]], ['Gbreve', [286]], ['gbreve', [287]], ['Gcedil', [290]], ['Gcirc', [284]], ['gcirc', [285]], ['Gcy', [1043]], ['gcy', [1075]], ['Gdot', [288]], ['gdot', [289]], ['ge', [8805]], ['gE', [8807]], ['gEl', [10892]], ['gel', [8923]], ['geq', [8805]], ['geqq', [8807]], ['geqslant', [10878]], ['gescc', [10921]], ['ges', [10878]], ['gesdot', [10880]], ['gesdoto', [10882]], ['gesdotol', [10884]], ['gesl', [8923, 65024]], ['gesles', [10900]], ['Gfr', [120074]], ['gfr', [120100]], ['gg', [8811]], ['Gg', [8921]], ['ggg', [8921]], ['gimel', [8503]], ['GJcy', [1027]], ['gjcy', [1107]], ['gla', [10917]], ['gl', [8823]], ['glE', [10898]], ['glj', [10916]], ['gnap', [10890]], ['gnapprox', [10890]], ['gne', [10888]], ['gnE', [8809]], ['gneq', [10888]], ['gneqq', [8809]], ['gnsim', [8935]], ['Gopf', [120126]], ['gopf', [120152]], ['grave', [96]], ['GreaterEqual', [8805]], ['GreaterEqualLess', [8923]], ['GreaterFullEqual', [8807]], ['GreaterGreater', [10914]], ['GreaterLess', [8823]], ['GreaterSlantEqual', [10878]], ['GreaterTilde', [8819]], ['Gscr', [119970]], ['gscr', [8458]], ['gsim', [8819]], ['gsime', [10894]], ['gsiml', [10896]], ['gtcc', [10919]], ['gtcir', [10874]], ['gt', [62]], ['GT', [62]], ['Gt', [8811]], ['gtdot', [8919]], ['gtlPar', [10645]], ['gtquest', [10876]], ['gtrapprox', [10886]], ['gtrarr', [10616]], ['gtrdot', [8919]], ['gtreqless', [8923]], ['gtreqqless', [10892]], ['gtrless', [8823]], ['gtrsim', [8819]], ['gvertneqq', [8809, 65024]], ['gvnE', [8809, 65024]], ['Hacek', [711]], ['hairsp', [8202]], ['half', [189]], ['hamilt', [8459]], ['HARDcy', [1066]], ['hardcy', [1098]], ['harrcir', [10568]], ['harr', [8596]], ['hArr', [8660]], ['harrw', [8621]], ['Hat', [94]], ['hbar', [8463]], ['Hcirc', [292]], ['hcirc', [293]], ['hearts', [9829]], ['heartsuit', [9829]], ['hellip', [8230]], ['hercon', [8889]], ['hfr', [120101]], ['Hfr', [8460]], ['HilbertSpace', [8459]], ['hksearow', [10533]], ['hkswarow', [10534]], ['hoarr', [8703]], ['homtht', [8763]], ['hookleftarrow', [8617]], ['hookrightarrow', [8618]], ['hopf', [120153]], ['Hopf', [8461]], ['horbar', [8213]], ['HorizontalLine', [9472]], ['hscr', [119997]], ['Hscr', [8459]], ['hslash', [8463]], ['Hstrok', [294]], ['hstrok', [295]], ['HumpDownHump', [8782]], ['HumpEqual', [8783]], ['hybull', [8259]], ['hyphen', [8208]], ['Iacute', [205]], ['iacute', [237]], ['ic', [8291]], ['Icirc', [206]], ['icirc', [238]], ['Icy', [1048]], ['icy', [1080]], ['Idot', [304]], ['IEcy', [1045]], ['iecy', [1077]], ['iexcl', [161]], ['iff', [8660]], ['ifr', [120102]], ['Ifr', [8465]], ['Igrave', [204]], ['igrave', [236]], ['ii', [8520]], ['iiiint', [10764]], ['iiint', [8749]], ['iinfin', [10716]], ['iiota', [8489]], ['IJlig', [306]], ['ijlig', [307]], ['Imacr', [298]], ['imacr', [299]], ['image', [8465]], ['ImaginaryI', [8520]], ['imagline', [8464]], ['imagpart', [8465]], ['imath', [305]], ['Im', [8465]], ['imof', [8887]], ['imped', [437]], ['Implies', [8658]], ['incare', [8453]], ['in', [8712]], ['infin', [8734]], ['infintie', [10717]], ['inodot', [305]], ['intcal', [8890]], ['int', [8747]], ['Int', [8748]], ['integers', [8484]], ['Integral', [8747]], ['intercal', [8890]], ['Intersection', [8898]], ['intlarhk', [10775]], ['intprod', [10812]], ['InvisibleComma', [8291]], ['InvisibleTimes', [8290]], ['IOcy', [1025]], ['iocy', [1105]], ['Iogon', [302]], ['iogon', [303]], ['Iopf', [120128]], ['iopf', [120154]], ['Iota', [921]], ['iota', [953]], ['iprod', [10812]], ['iquest', [191]], ['iscr', [119998]], ['Iscr', [8464]], ['isin', [8712]], ['isindot', [8949]], ['isinE', [8953]], ['isins', [8948]], ['isinsv', [8947]], ['isinv', [8712]], ['it', [8290]], ['Itilde', [296]], ['itilde', [297]], ['Iukcy', [1030]], ['iukcy', [1110]], ['Iuml', [207]], ['iuml', [239]], ['Jcirc', [308]], ['jcirc', [309]], ['Jcy', [1049]], ['jcy', [1081]], ['Jfr', [120077]], ['jfr', [120103]], ['jmath', [567]], ['Jopf', [120129]], ['jopf', [120155]], ['Jscr', [119973]], ['jscr', [119999]], ['Jsercy', [1032]], ['jsercy', [1112]], ['Jukcy', [1028]], ['jukcy', [1108]], ['Kappa', [922]], ['kappa', [954]], ['kappav', [1008]], ['Kcedil', [310]], ['kcedil', [311]], ['Kcy', [1050]], ['kcy', [1082]], ['Kfr', [120078]], ['kfr', [120104]], ['kgreen', [312]], ['KHcy', [1061]], ['khcy', [1093]], ['KJcy', [1036]], ['kjcy', [1116]], ['Kopf', [120130]], ['kopf', [120156]], ['Kscr', [119974]], ['kscr', [120000]], ['lAarr', [8666]], ['Lacute', [313]], ['lacute', [314]], ['laemptyv', [10676]], ['lagran', [8466]], ['Lambda', [923]], ['lambda', [955]], ['lang', [10216]], ['Lang', [10218]], ['langd', [10641]], ['langle', [10216]], ['lap', [10885]], ['Laplacetrf', [8466]], ['laquo', [171]], ['larrb', [8676]], ['larrbfs', [10527]], ['larr', [8592]], ['Larr', [8606]], ['lArr', [8656]], ['larrfs', [10525]], ['larrhk', [8617]], ['larrlp', [8619]], ['larrpl', [10553]], ['larrsim', [10611]], ['larrtl', [8610]], ['latail', [10521]], ['lAtail', [10523]], ['lat', [10923]], ['late', [10925]], ['lates', [10925, 65024]], ['lbarr', [10508]], ['lBarr', [10510]], ['lbbrk', [10098]], ['lbrace', [123]], ['lbrack', [91]], ['lbrke', [10635]], ['lbrksld', [10639]], ['lbrkslu', [10637]], ['Lcaron', [317]], ['lcaron', [318]], ['Lcedil', [315]], ['lcedil', [316]], ['lceil', [8968]], ['lcub', [123]], ['Lcy', [1051]], ['lcy', [1083]], ['ldca', [10550]], ['ldquo', [8220]], ['ldquor', [8222]], ['ldrdhar', [10599]], ['ldrushar', [10571]], ['ldsh', [8626]], ['le', [8804]], ['lE', [8806]], ['LeftAngleBracket', [10216]], ['LeftArrowBar', [8676]], ['leftarrow', [8592]], ['LeftArrow', [8592]], ['Leftarrow', [8656]], ['LeftArrowRightArrow', [8646]], ['leftarrowtail', [8610]], ['LeftCeiling', [8968]], ['LeftDoubleBracket', [10214]], ['LeftDownTeeVector', [10593]], ['LeftDownVectorBar', [10585]], ['LeftDownVector', [8643]], ['LeftFloor', [8970]], ['leftharpoondown', [8637]], ['leftharpoonup', [8636]], ['leftleftarrows', [8647]], ['leftrightarrow', [8596]], ['LeftRightArrow', [8596]], ['Leftrightarrow', [8660]], ['leftrightarrows', [8646]], ['leftrightharpoons', [8651]], ['leftrightsquigarrow', [8621]], ['LeftRightVector', [10574]], ['LeftTeeArrow', [8612]], ['LeftTee', [8867]], ['LeftTeeVector', [10586]], ['leftthreetimes', [8907]], ['LeftTriangleBar', [10703]], ['LeftTriangle', [8882]], ['LeftTriangleEqual', [8884]], ['LeftUpDownVector', [10577]], ['LeftUpTeeVector', [10592]], ['LeftUpVectorBar', [10584]], ['LeftUpVector', [8639]], ['LeftVectorBar', [10578]], ['LeftVector', [8636]], ['lEg', [10891]], ['leg', [8922]], ['leq', [8804]], ['leqq', [8806]], ['leqslant', [10877]], ['lescc', [10920]], ['les', [10877]], ['lesdot', [10879]], ['lesdoto', [10881]], ['lesdotor', [10883]], ['lesg', [8922, 65024]], ['lesges', [10899]], ['lessapprox', [10885]], ['lessdot', [8918]], ['lesseqgtr', [8922]], ['lesseqqgtr', [10891]], ['LessEqualGreater', [8922]], ['LessFullEqual', [8806]], ['LessGreater', [8822]], ['lessgtr', [8822]], ['LessLess', [10913]], ['lesssim', [8818]], ['LessSlantEqual', [10877]], ['LessTilde', [8818]], ['lfisht', [10620]], ['lfloor', [8970]], ['Lfr', [120079]], ['lfr', [120105]], ['lg', [8822]], ['lgE', [10897]], ['lHar', [10594]], ['lhard', [8637]], ['lharu', [8636]], ['lharul', [10602]], ['lhblk', [9604]], ['LJcy', [1033]], ['ljcy', [1113]], ['llarr', [8647]], ['ll', [8810]], ['Ll', [8920]], ['llcorner', [8990]], ['Lleftarrow', [8666]], ['llhard', [10603]], ['lltri', [9722]], ['Lmidot', [319]], ['lmidot', [320]], ['lmoustache', [9136]], ['lmoust', [9136]], ['lnap', [10889]], ['lnapprox', [10889]], ['lne', [10887]], ['lnE', [8808]], ['lneq', [10887]], ['lneqq', [8808]], ['lnsim', [8934]], ['loang', [10220]], ['loarr', [8701]], ['lobrk', [10214]], ['longleftarrow', [10229]], ['LongLeftArrow', [10229]], ['Longleftarrow', [10232]], ['longleftrightarrow', [10231]], ['LongLeftRightArrow', [10231]], ['Longleftrightarrow', [10234]], ['longmapsto', [10236]], ['longrightarrow', [10230]], ['LongRightArrow', [10230]], ['Longrightarrow', [10233]], ['looparrowleft', [8619]], ['looparrowright', [8620]], ['lopar', [10629]], ['Lopf', [120131]], ['lopf', [120157]], ['loplus', [10797]], ['lotimes', [10804]], ['lowast', [8727]], ['lowbar', [95]], ['LowerLeftArrow', [8601]], ['LowerRightArrow', [8600]], ['loz', [9674]], ['lozenge', [9674]], ['lozf', [10731]], ['lpar', [40]], ['lparlt', [10643]], ['lrarr', [8646]], ['lrcorner', [8991]], ['lrhar', [8651]], ['lrhard', [10605]], ['lrm', [8206]], ['lrtri', [8895]], ['lsaquo', [8249]], ['lscr', [120001]], ['Lscr', [8466]], ['lsh', [8624]], ['Lsh', [8624]], ['lsim', [8818]], ['lsime', [10893]], ['lsimg', [10895]], ['lsqb', [91]], ['lsquo', [8216]], ['lsquor', [8218]], ['Lstrok', [321]], ['lstrok', [322]], ['ltcc', [10918]], ['ltcir', [10873]], ['lt', [60]], ['LT', [60]], ['Lt', [8810]], ['ltdot', [8918]], ['lthree', [8907]], ['ltimes', [8905]], ['ltlarr', [10614]], ['ltquest', [10875]], ['ltri', [9667]], ['ltrie', [8884]], ['ltrif', [9666]], ['ltrPar', [10646]], ['lurdshar', [10570]], ['luruhar', [10598]], ['lvertneqq', [8808, 65024]], ['lvnE', [8808, 65024]], ['macr', [175]], ['male', [9794]], ['malt', [10016]], ['maltese', [10016]], ['Map', [10501]], ['map', [8614]], ['mapsto', [8614]], ['mapstodown', [8615]], ['mapstoleft', [8612]], ['mapstoup', [8613]], ['marker', [9646]], ['mcomma', [10793]], ['Mcy', [1052]], ['mcy', [1084]], ['mdash', [8212]], ['mDDot', [8762]], ['measuredangle', [8737]], ['MediumSpace', [8287]], ['Mellintrf', [8499]], ['Mfr', [120080]], ['mfr', [120106]], ['mho', [8487]], ['micro', [181]], ['midast', [42]], ['midcir', [10992]], ['mid', [8739]], ['middot', [183]], ['minusb', [8863]], ['minus', [8722]], ['minusd', [8760]], ['minusdu', [10794]], ['MinusPlus', [8723]], ['mlcp', [10971]], ['mldr', [8230]], ['mnplus', [8723]], ['models', [8871]], ['Mopf', [120132]], ['mopf', [120158]], ['mp', [8723]], ['mscr', [120002]], ['Mscr', [8499]], ['mstpos', [8766]], ['Mu', [924]], ['mu', [956]], ['multimap', [8888]], ['mumap', [8888]], ['nabla', [8711]], ['Nacute', [323]], ['nacute', [324]], ['nang', [8736, 8402]], ['nap', [8777]], ['napE', [10864, 824]], ['napid', [8779, 824]], ['napos', [329]], ['napprox', [8777]], ['natural', [9838]], ['naturals', [8469]], ['natur', [9838]], ['nbsp', [160]], ['nbump', [8782, 824]], ['nbumpe', [8783, 824]], ['ncap', [10819]], ['Ncaron', [327]], ['ncaron', [328]], ['Ncedil', [325]], ['ncedil', [326]], ['ncong', [8775]], ['ncongdot', [10861, 824]], ['ncup', [10818]], ['Ncy', [1053]], ['ncy', [1085]], ['ndash', [8211]], ['nearhk', [10532]], ['nearr', [8599]], ['neArr', [8663]], ['nearrow', [8599]], ['ne', [8800]], ['nedot', [8784, 824]], ['NegativeMediumSpace', [8203]], ['NegativeThickSpace', [8203]], ['NegativeThinSpace', [8203]], ['NegativeVeryThinSpace', [8203]], ['nequiv', [8802]], ['nesear', [10536]], ['nesim', [8770, 824]], ['NestedGreaterGreater', [8811]], ['NestedLessLess', [8810]], ['nexist', [8708]], ['nexists', [8708]], ['Nfr', [120081]], ['nfr', [120107]], ['ngE', [8807, 824]], ['nge', [8817]], ['ngeq', [8817]], ['ngeqq', [8807, 824]], ['ngeqslant', [10878, 824]], ['nges', [10878, 824]], ['nGg', [8921, 824]], ['ngsim', [8821]], ['nGt', [8811, 8402]], ['ngt', [8815]], ['ngtr', [8815]], ['nGtv', [8811, 824]], ['nharr', [8622]], ['nhArr', [8654]], ['nhpar', [10994]], ['ni', [8715]], ['nis', [8956]], ['nisd', [8954]], ['niv', [8715]], ['NJcy', [1034]], ['njcy', [1114]], ['nlarr', [8602]], ['nlArr', [8653]], ['nldr', [8229]], ['nlE', [8806, 824]], ['nle', [8816]], ['nleftarrow', [8602]], ['nLeftarrow', [8653]], ['nleftrightarrow', [8622]], ['nLeftrightarrow', [8654]], ['nleq', [8816]], ['nleqq', [8806, 824]], ['nleqslant', [10877, 824]], ['nles', [10877, 824]], ['nless', [8814]], ['nLl', [8920, 824]], ['nlsim', [8820]], ['nLt', [8810, 8402]], ['nlt', [8814]], ['nltri', [8938]], ['nltrie', [8940]], ['nLtv', [8810, 824]], ['nmid', [8740]], ['NoBreak', [8288]], ['NonBreakingSpace', [160]], ['nopf', [120159]], ['Nopf', [8469]], ['Not', [10988]], ['not', [172]], ['NotCongruent', [8802]], ['NotCupCap', [8813]], ['NotDoubleVerticalBar', [8742]], ['NotElement', [8713]], ['NotEqual', [8800]], ['NotEqualTilde', [8770, 824]], ['NotExists', [8708]], ['NotGreater', [8815]], ['NotGreaterEqual', [8817]], ['NotGreaterFullEqual', [8807, 824]], ['NotGreaterGreater', [8811, 824]], ['NotGreaterLess', [8825]], ['NotGreaterSlantEqual', [10878, 824]], ['NotGreaterTilde', [8821]], ['NotHumpDownHump', [8782, 824]], ['NotHumpEqual', [8783, 824]], ['notin', [8713]], ['notindot', [8949, 824]], ['notinE', [8953, 824]], ['notinva', [8713]], ['notinvb', [8951]], ['notinvc', [8950]], ['NotLeftTriangleBar', [10703, 824]], ['NotLeftTriangle', [8938]], ['NotLeftTriangleEqual', [8940]], ['NotLess', [8814]], ['NotLessEqual', [8816]], ['NotLessGreater', [8824]], ['NotLessLess', [8810, 824]], ['NotLessSlantEqual', [10877, 824]], ['NotLessTilde', [8820]], ['NotNestedGreaterGreater', [10914, 824]], ['NotNestedLessLess', [10913, 824]], ['notni', [8716]], ['notniva', [8716]], ['notnivb', [8958]], ['notnivc', [8957]], ['NotPrecedes', [8832]], ['NotPrecedesEqual', [10927, 824]], ['NotPrecedesSlantEqual', [8928]], ['NotReverseElement', [8716]], ['NotRightTriangleBar', [10704, 824]], ['NotRightTriangle', [8939]], ['NotRightTriangleEqual', [8941]], ['NotSquareSubset', [8847, 824]], ['NotSquareSubsetEqual', [8930]], ['NotSquareSuperset', [8848, 824]], ['NotSquareSupersetEqual', [8931]], ['NotSubset', [8834, 8402]], ['NotSubsetEqual', [8840]], ['NotSucceeds', [8833]], ['NotSucceedsEqual', [10928, 824]], ['NotSucceedsSlantEqual', [8929]], ['NotSucceedsTilde', [8831, 824]], ['NotSuperset', [8835, 8402]], ['NotSupersetEqual', [8841]], ['NotTilde', [8769]], ['NotTildeEqual', [8772]], ['NotTildeFullEqual', [8775]], ['NotTildeTilde', [8777]], ['NotVerticalBar', [8740]], ['nparallel', [8742]], ['npar', [8742]], ['nparsl', [11005, 8421]], ['npart', [8706, 824]], ['npolint', [10772]], ['npr', [8832]], ['nprcue', [8928]], ['nprec', [8832]], ['npreceq', [10927, 824]], ['npre', [10927, 824]], ['nrarrc', [10547, 824]], ['nrarr', [8603]], ['nrArr', [8655]], ['nrarrw', [8605, 824]], ['nrightarrow', [8603]], ['nRightarrow', [8655]], ['nrtri', [8939]], ['nrtrie', [8941]], ['nsc', [8833]], ['nsccue', [8929]], ['nsce', [10928, 824]], ['Nscr', [119977]], ['nscr', [120003]], ['nshortmid', [8740]], ['nshortparallel', [8742]], ['nsim', [8769]], ['nsime', [8772]], ['nsimeq', [8772]], ['nsmid', [8740]], ['nspar', [8742]], ['nsqsube', [8930]], ['nsqsupe', [8931]], ['nsub', [8836]], ['nsubE', [10949, 824]], ['nsube', [8840]], ['nsubset', [8834, 8402]], ['nsubseteq', [8840]], ['nsubseteqq', [10949, 824]], ['nsucc', [8833]], ['nsucceq', [10928, 824]], ['nsup', [8837]], ['nsupE', [10950, 824]], ['nsupe', [8841]], ['nsupset', [8835, 8402]], ['nsupseteq', [8841]], ['nsupseteqq', [10950, 824]], ['ntgl', [8825]], ['Ntilde', [209]], ['ntilde', [241]], ['ntlg', [8824]], ['ntriangleleft', [8938]], ['ntrianglelefteq', [8940]], ['ntriangleright', [8939]], ['ntrianglerighteq', [8941]], ['Nu', [925]], ['nu', [957]], ['num', [35]], ['numero', [8470]], ['numsp', [8199]], ['nvap', [8781, 8402]], ['nvdash', [8876]], ['nvDash', [8877]], ['nVdash', [8878]], ['nVDash', [8879]], ['nvge', [8805, 8402]], ['nvgt', [62, 8402]], ['nvHarr', [10500]], ['nvinfin', [10718]], ['nvlArr', [10498]], ['nvle', [8804, 8402]], ['nvlt', [60, 8402]], ['nvltrie', [8884, 8402]], ['nvrArr', [10499]], ['nvrtrie', [8885, 8402]], ['nvsim', [8764, 8402]], ['nwarhk', [10531]], ['nwarr', [8598]], ['nwArr', [8662]], ['nwarrow', [8598]], ['nwnear', [10535]], ['Oacute', [211]], ['oacute', [243]], ['oast', [8859]], ['Ocirc', [212]], ['ocirc', [244]], ['ocir', [8858]], ['Ocy', [1054]], ['ocy', [1086]], ['odash', [8861]], ['Odblac', [336]], ['odblac', [337]], ['odiv', [10808]], ['odot', [8857]], ['odsold', [10684]], ['OElig', [338]], ['oelig', [339]], ['ofcir', [10687]], ['Ofr', [120082]], ['ofr', [120108]], ['ogon', [731]], ['Ograve', [210]], ['ograve', [242]], ['ogt', [10689]], ['ohbar', [10677]], ['ohm', [937]], ['oint', [8750]], ['olarr', [8634]], ['olcir', [10686]], ['olcross', [10683]], ['oline', [8254]], ['olt', [10688]], ['Omacr', [332]], ['omacr', [333]], ['Omega', [937]], ['omega', [969]], ['Omicron', [927]], ['omicron', [959]], ['omid', [10678]], ['ominus', [8854]], ['Oopf', [120134]], ['oopf', [120160]], ['opar', [10679]], ['OpenCurlyDoubleQuote', [8220]], ['OpenCurlyQuote', [8216]], ['operp', [10681]], ['oplus', [8853]], ['orarr', [8635]], ['Or', [10836]], ['or', [8744]], ['ord', [10845]], ['order', [8500]], ['orderof', [8500]], ['ordf', [170]], ['ordm', [186]], ['origof', [8886]], ['oror', [10838]], ['orslope', [10839]], ['orv', [10843]], ['oS', [9416]], ['Oscr', [119978]], ['oscr', [8500]], ['Oslash', [216]], ['oslash', [248]], ['osol', [8856]], ['Otilde', [213]], ['otilde', [245]], ['otimesas', [10806]], ['Otimes', [10807]], ['otimes', [8855]], ['Ouml', [214]], ['ouml', [246]], ['ovbar', [9021]], ['OverBar', [8254]], ['OverBrace', [9182]], ['OverBracket', [9140]], ['OverParenthesis', [9180]], ['para', [182]], ['parallel', [8741]], ['par', [8741]], ['parsim', [10995]], ['parsl', [11005]], ['part', [8706]], ['PartialD', [8706]], ['Pcy', [1055]], ['pcy', [1087]], ['percnt', [37]], ['period', [46]], ['permil', [8240]], ['perp', [8869]], ['pertenk', [8241]], ['Pfr', [120083]], ['pfr', [120109]], ['Phi', [934]], ['phi', [966]], ['phiv', [981]], ['phmmat', [8499]], ['phone', [9742]], ['Pi', [928]], ['pi', [960]], ['pitchfork', [8916]], ['piv', [982]], ['planck', [8463]], ['planckh', [8462]], ['plankv', [8463]], ['plusacir', [10787]], ['plusb', [8862]], ['pluscir', [10786]], ['plus', [43]], ['plusdo', [8724]], ['plusdu', [10789]], ['pluse', [10866]], ['PlusMinus', [177]], ['plusmn', [177]], ['plussim', [10790]], ['plustwo', [10791]], ['pm', [177]], ['Poincareplane', [8460]], ['pointint', [10773]], ['popf', [120161]], ['Popf', [8473]], ['pound', [163]], ['prap', [10935]], ['Pr', [10939]], ['pr', [8826]], ['prcue', [8828]], ['precapprox', [10935]], ['prec', [8826]], ['preccurlyeq', [8828]], ['Precedes', [8826]], ['PrecedesEqual', [10927]], ['PrecedesSlantEqual', [8828]], ['PrecedesTilde', [8830]], ['preceq', [10927]], ['precnapprox', [10937]], ['precneqq', [10933]], ['precnsim', [8936]], ['pre', [10927]], ['prE', [10931]], ['precsim', [8830]], ['prime', [8242]], ['Prime', [8243]], ['primes', [8473]], ['prnap', [10937]], ['prnE', [10933]], ['prnsim', [8936]], ['prod', [8719]], ['Product', [8719]], ['profalar', [9006]], ['profline', [8978]], ['profsurf', [8979]], ['prop', [8733]], ['Proportional', [8733]], ['Proportion', [8759]], ['propto', [8733]], ['prsim', [8830]], ['prurel', [8880]], ['Pscr', [119979]], ['pscr', [120005]], ['Psi', [936]], ['psi', [968]], ['puncsp', [8200]], ['Qfr', [120084]], ['qfr', [120110]], ['qint', [10764]], ['qopf', [120162]], ['Qopf', [8474]], ['qprime', [8279]], ['Qscr', [119980]], ['qscr', [120006]], ['quaternions', [8461]], ['quatint', [10774]], ['quest', [63]], ['questeq', [8799]], ['quot', [34]], ['QUOT', [34]], ['rAarr', [8667]], ['race', [8765, 817]], ['Racute', [340]], ['racute', [341]], ['radic', [8730]], ['raemptyv', [10675]], ['rang', [10217]], ['Rang', [10219]], ['rangd', [10642]], ['range', [10661]], ['rangle', [10217]], ['raquo', [187]], ['rarrap', [10613]], ['rarrb', [8677]], ['rarrbfs', [10528]], ['rarrc', [10547]], ['rarr', [8594]], ['Rarr', [8608]], ['rArr', [8658]], ['rarrfs', [10526]], ['rarrhk', [8618]], ['rarrlp', [8620]], ['rarrpl', [10565]], ['rarrsim', [10612]], ['Rarrtl', [10518]], ['rarrtl', [8611]], ['rarrw', [8605]], ['ratail', [10522]], ['rAtail', [10524]], ['ratio', [8758]], ['rationals', [8474]], ['rbarr', [10509]], ['rBarr', [10511]], ['RBarr', [10512]], ['rbbrk', [10099]], ['rbrace', [125]], ['rbrack', [93]], ['rbrke', [10636]], ['rbrksld', [10638]], ['rbrkslu', [10640]], ['Rcaron', [344]], ['rcaron', [345]], ['Rcedil', [342]], ['rcedil', [343]], ['rceil', [8969]], ['rcub', [125]], ['Rcy', [1056]], ['rcy', [1088]], ['rdca', [10551]], ['rdldhar', [10601]], ['rdquo', [8221]], ['rdquor', [8221]], ['CloseCurlyDoubleQuote', [8221]], ['rdsh', [8627]], ['real', [8476]], ['realine', [8475]], ['realpart', [8476]], ['reals', [8477]], ['Re', [8476]], ['rect', [9645]], ['reg', [174]], ['REG', [174]], ['ReverseElement', [8715]], ['ReverseEquilibrium', [8651]], ['ReverseUpEquilibrium', [10607]], ['rfisht', [10621]], ['rfloor', [8971]], ['rfr', [120111]], ['Rfr', [8476]], ['rHar', [10596]], ['rhard', [8641]], ['rharu', [8640]], ['rharul', [10604]], ['Rho', [929]], ['rho', [961]], ['rhov', [1009]], ['RightAngleBracket', [10217]], ['RightArrowBar', [8677]], ['rightarrow', [8594]], ['RightArrow', [8594]], ['Rightarrow', [8658]], ['RightArrowLeftArrow', [8644]], ['rightarrowtail', [8611]], ['RightCeiling', [8969]], ['RightDoubleBracket', [10215]], ['RightDownTeeVector', [10589]], ['RightDownVectorBar', [10581]], ['RightDownVector', [8642]], ['RightFloor', [8971]], ['rightharpoondown', [8641]], ['rightharpoonup', [8640]], ['rightleftarrows', [8644]], ['rightleftharpoons', [8652]], ['rightrightarrows', [8649]], ['rightsquigarrow', [8605]], ['RightTeeArrow', [8614]], ['RightTee', [8866]], ['RightTeeVector', [10587]], ['rightthreetimes', [8908]], ['RightTriangleBar', [10704]], ['RightTriangle', [8883]], ['RightTriangleEqual', [8885]], ['RightUpDownVector', [10575]], ['RightUpTeeVector', [10588]], ['RightUpVectorBar', [10580]], ['RightUpVector', [8638]], ['RightVectorBar', [10579]], ['RightVector', [8640]], ['ring', [730]], ['risingdotseq', [8787]], ['rlarr', [8644]], ['rlhar', [8652]], ['rlm', [8207]], ['rmoustache', [9137]], ['rmoust', [9137]], ['rnmid', [10990]], ['roang', [10221]], ['roarr', [8702]], ['robrk', [10215]], ['ropar', [10630]], ['ropf', [120163]], ['Ropf', [8477]], ['roplus', [10798]], ['rotimes', [10805]], ['RoundImplies', [10608]], ['rpar', [41]], ['rpargt', [10644]], ['rppolint', [10770]], ['rrarr', [8649]], ['Rrightarrow', [8667]], ['rsaquo', [8250]], ['rscr', [120007]], ['Rscr', [8475]], ['rsh', [8625]], ['Rsh', [8625]], ['rsqb', [93]], ['rsquo', [8217]], ['rsquor', [8217]], ['CloseCurlyQuote', [8217]], ['rthree', [8908]], ['rtimes', [8906]], ['rtri', [9657]], ['rtrie', [8885]], ['rtrif', [9656]], ['rtriltri', [10702]], ['RuleDelayed', [10740]], ['ruluhar', [10600]], ['rx', [8478]], ['Sacute', [346]], ['sacute', [347]], ['sbquo', [8218]], ['scap', [10936]], ['Scaron', [352]], ['scaron', [353]], ['Sc', [10940]], ['sc', [8827]], ['sccue', [8829]], ['sce', [10928]], ['scE', [10932]], ['Scedil', [350]], ['scedil', [351]], ['Scirc', [348]], ['scirc', [349]], ['scnap', [10938]], ['scnE', [10934]], ['scnsim', [8937]], ['scpolint', [10771]], ['scsim', [8831]], ['Scy', [1057]], ['scy', [1089]], ['sdotb', [8865]], ['sdot', [8901]], ['sdote', [10854]], ['searhk', [10533]], ['searr', [8600]], ['seArr', [8664]], ['searrow', [8600]], ['sect', [167]], ['semi', [59]], ['seswar', [10537]], ['setminus', [8726]], ['setmn', [8726]], ['sext', [10038]], ['Sfr', [120086]], ['sfr', [120112]], ['sfrown', [8994]], ['sharp', [9839]], ['SHCHcy', [1065]], ['shchcy', [1097]], ['SHcy', [1064]], ['shcy', [1096]], ['ShortDownArrow', [8595]], ['ShortLeftArrow', [8592]], ['shortmid', [8739]], ['shortparallel', [8741]], ['ShortRightArrow', [8594]], ['ShortUpArrow', [8593]], ['shy', [173]], ['Sigma', [931]], ['sigma', [963]], ['sigmaf', [962]], ['sigmav', [962]], ['sim', [8764]], ['simdot', [10858]], ['sime', [8771]], ['simeq', [8771]], ['simg', [10910]], ['simgE', [10912]], ['siml', [10909]], ['simlE', [10911]], ['simne', [8774]], ['simplus', [10788]], ['simrarr', [10610]], ['slarr', [8592]], ['SmallCircle', [8728]], ['smallsetminus', [8726]], ['smashp', [10803]], ['smeparsl', [10724]], ['smid', [8739]], ['smile', [8995]], ['smt', [10922]], ['smte', [10924]], ['smtes', [10924, 65024]], ['SOFTcy', [1068]], ['softcy', [1100]], ['solbar', [9023]], ['solb', [10692]], ['sol', [47]], ['Sopf', [120138]], ['sopf', [120164]], ['spades', [9824]], ['spadesuit', [9824]], ['spar', [8741]], ['sqcap', [8851]], ['sqcaps', [8851, 65024]], ['sqcup', [8852]], ['sqcups', [8852, 65024]], ['Sqrt', [8730]], ['sqsub', [8847]], ['sqsube', [8849]], ['sqsubset', [8847]], ['sqsubseteq', [8849]], ['sqsup', [8848]], ['sqsupe', [8850]], ['sqsupset', [8848]], ['sqsupseteq', [8850]], ['square', [9633]], ['Square', [9633]], ['SquareIntersection', [8851]], ['SquareSubset', [8847]], ['SquareSubsetEqual', [8849]], ['SquareSuperset', [8848]], ['SquareSupersetEqual', [8850]], ['SquareUnion', [8852]], ['squarf', [9642]], ['squ', [9633]], ['squf', [9642]], ['srarr', [8594]], ['Sscr', [119982]], ['sscr', [120008]], ['ssetmn', [8726]], ['ssmile', [8995]], ['sstarf', [8902]], ['Star', [8902]], ['star', [9734]], ['starf', [9733]], ['straightepsilon', [1013]], ['straightphi', [981]], ['strns', [175]], ['sub', [8834]], ['Sub', [8912]], ['subdot', [10941]], ['subE', [10949]], ['sube', [8838]], ['subedot', [10947]], ['submult', [10945]], ['subnE', [10955]], ['subne', [8842]], ['subplus', [10943]], ['subrarr', [10617]], ['subset', [8834]], ['Subset', [8912]], ['subseteq', [8838]], ['subseteqq', [10949]], ['SubsetEqual', [8838]], ['subsetneq', [8842]], ['subsetneqq', [10955]], ['subsim', [10951]], ['subsub', [10965]], ['subsup', [10963]], ['succapprox', [10936]], ['succ', [8827]], ['succcurlyeq', [8829]], ['Succeeds', [8827]], ['SucceedsEqual', [10928]], ['SucceedsSlantEqual', [8829]], ['SucceedsTilde', [8831]], ['succeq', [10928]], ['succnapprox', [10938]], ['succneqq', [10934]], ['succnsim', [8937]], ['succsim', [8831]], ['SuchThat', [8715]], ['sum', [8721]], ['Sum', [8721]], ['sung', [9834]], ['sup1', [185]], ['sup2', [178]], ['sup3', [179]], ['sup', [8835]], ['Sup', [8913]], ['supdot', [10942]], ['supdsub', [10968]], ['supE', [10950]], ['supe', [8839]], ['supedot', [10948]], ['Superset', [8835]], ['SupersetEqual', [8839]], ['suphsol', [10185]], ['suphsub', [10967]], ['suplarr', [10619]], ['supmult', [10946]], ['supnE', [10956]], ['supne', [8843]], ['supplus', [10944]], ['supset', [8835]], ['Supset', [8913]], ['supseteq', [8839]], ['supseteqq', [10950]], ['supsetneq', [8843]], ['supsetneqq', [10956]], ['supsim', [10952]], ['supsub', [10964]], ['supsup', [10966]], ['swarhk', [10534]], ['swarr', [8601]], ['swArr', [8665]], ['swarrow', [8601]], ['swnwar', [10538]], ['szlig', [223]], ['Tab', [9]], ['target', [8982]], ['Tau', [932]], ['tau', [964]], ['tbrk', [9140]], ['Tcaron', [356]], ['tcaron', [357]], ['Tcedil', [354]], ['tcedil', [355]], ['Tcy', [1058]], ['tcy', [1090]], ['tdot', [8411]], ['telrec', [8981]], ['Tfr', [120087]], ['tfr', [120113]], ['there4', [8756]], ['therefore', [8756]], ['Therefore', [8756]], ['Theta', [920]], ['theta', [952]], ['thetasym', [977]], ['thetav', [977]], ['thickapprox', [8776]], ['thicksim', [8764]], ['ThickSpace', [8287, 8202]], ['ThinSpace', [8201]], ['thinsp', [8201]], ['thkap', [8776]], ['thksim', [8764]], ['THORN', [222]], ['thorn', [254]], ['tilde', [732]], ['Tilde', [8764]], ['TildeEqual', [8771]], ['TildeFullEqual', [8773]], ['TildeTilde', [8776]], ['timesbar', [10801]], ['timesb', [8864]], ['times', [215]], ['timesd', [10800]], ['tint', [8749]], ['toea', [10536]], ['topbot', [9014]], ['topcir', [10993]], ['top', [8868]], ['Topf', [120139]], ['topf', [120165]], ['topfork', [10970]], ['tosa', [10537]], ['tprime', [8244]], ['trade', [8482]], ['TRADE', [8482]], ['triangle', [9653]], ['triangledown', [9663]], ['triangleleft', [9667]], ['trianglelefteq', [8884]], ['triangleq', [8796]], ['triangleright', [9657]], ['trianglerighteq', [8885]], ['tridot', [9708]], ['trie', [8796]], ['triminus', [10810]], ['TripleDot', [8411]], ['triplus', [10809]], ['trisb', [10701]], ['tritime', [10811]], ['trpezium', [9186]], ['Tscr', [119983]], ['tscr', [120009]], ['TScy', [1062]], ['tscy', [1094]], ['TSHcy', [1035]], ['tshcy', [1115]], ['Tstrok', [358]], ['tstrok', [359]], ['twixt', [8812]], ['twoheadleftarrow', [8606]], ['twoheadrightarrow', [8608]], ['Uacute', [218]], ['uacute', [250]], ['uarr', [8593]], ['Uarr', [8607]], ['uArr', [8657]], ['Uarrocir', [10569]], ['Ubrcy', [1038]], ['ubrcy', [1118]], ['Ubreve', [364]], ['ubreve', [365]], ['Ucirc', [219]], ['ucirc', [251]], ['Ucy', [1059]], ['ucy', [1091]], ['udarr', [8645]], ['Udblac', [368]], ['udblac', [369]], ['udhar', [10606]], ['ufisht', [10622]], ['Ufr', [120088]], ['ufr', [120114]], ['Ugrave', [217]], ['ugrave', [249]], ['uHar', [10595]], ['uharl', [8639]], ['uharr', [8638]], ['uhblk', [9600]], ['ulcorn', [8988]], ['ulcorner', [8988]], ['ulcrop', [8975]], ['ultri', [9720]], ['Umacr', [362]], ['umacr', [363]], ['uml', [168]], ['UnderBar', [95]], ['UnderBrace', [9183]], ['UnderBracket', [9141]], ['UnderParenthesis', [9181]], ['Union', [8899]], ['UnionPlus', [8846]], ['Uogon', [370]], ['uogon', [371]], ['Uopf', [120140]], ['uopf', [120166]], ['UpArrowBar', [10514]], ['uparrow', [8593]], ['UpArrow', [8593]], ['Uparrow', [8657]], ['UpArrowDownArrow', [8645]], ['updownarrow', [8597]], ['UpDownArrow', [8597]], ['Updownarrow', [8661]], ['UpEquilibrium', [10606]], ['upharpoonleft', [8639]], ['upharpoonright', [8638]], ['uplus', [8846]], ['UpperLeftArrow', [8598]], ['UpperRightArrow', [8599]], ['upsi', [965]], ['Upsi', [978]], ['upsih', [978]], ['Upsilon', [933]], ['upsilon', [965]], ['UpTeeArrow', [8613]], ['UpTee', [8869]], ['upuparrows', [8648]], ['urcorn', [8989]], ['urcorner', [8989]], ['urcrop', [8974]], ['Uring', [366]], ['uring', [367]], ['urtri', [9721]], ['Uscr', [119984]], ['uscr', [120010]], ['utdot', [8944]], ['Utilde', [360]], ['utilde', [361]], ['utri', [9653]], ['utrif', [9652]], ['uuarr', [8648]], ['Uuml', [220]], ['uuml', [252]], ['uwangle', [10663]], ['vangrt', [10652]], ['varepsilon', [1013]], ['varkappa', [1008]], ['varnothing', [8709]], ['varphi', [981]], ['varpi', [982]], ['varpropto', [8733]], ['varr', [8597]], ['vArr', [8661]], ['varrho', [1009]], ['varsigma', [962]], ['varsubsetneq', [8842, 65024]], ['varsubsetneqq', [10955, 65024]], ['varsupsetneq', [8843, 65024]], ['varsupsetneqq', [10956, 65024]], ['vartheta', [977]], ['vartriangleleft', [8882]], ['vartriangleright', [8883]], ['vBar', [10984]], ['Vbar', [10987]], ['vBarv', [10985]], ['Vcy', [1042]], ['vcy', [1074]], ['vdash', [8866]], ['vDash', [8872]], ['Vdash', [8873]], ['VDash', [8875]], ['Vdashl', [10982]], ['veebar', [8891]], ['vee', [8744]], ['Vee', [8897]], ['veeeq', [8794]], ['vellip', [8942]], ['verbar', [124]], ['Verbar', [8214]], ['vert', [124]], ['Vert', [8214]], ['VerticalBar', [8739]], ['VerticalLine', [124]], ['VerticalSeparator', [10072]], ['VerticalTilde', [8768]], ['VeryThinSpace', [8202]], ['Vfr', [120089]], ['vfr', [120115]], ['vltri', [8882]], ['vnsub', [8834, 8402]], ['vnsup', [8835, 8402]], ['Vopf', [120141]], ['vopf', [120167]], ['vprop', [8733]], ['vrtri', [8883]], ['Vscr', [119985]], ['vscr', [120011]], ['vsubnE', [10955, 65024]], ['vsubne', [8842, 65024]], ['vsupnE', [10956, 65024]], ['vsupne', [8843, 65024]], ['Vvdash', [8874]], ['vzigzag', [10650]], ['Wcirc', [372]], ['wcirc', [373]], ['wedbar', [10847]], ['wedge', [8743]], ['Wedge', [8896]], ['wedgeq', [8793]], ['weierp', [8472]], ['Wfr', [120090]], ['wfr', [120116]], ['Wopf', [120142]], ['wopf', [120168]], ['wp', [8472]], ['wr', [8768]], ['wreath', [8768]], ['Wscr', [119986]], ['wscr', [120012]], ['xcap', [8898]], ['xcirc', [9711]], ['xcup', [8899]], ['xdtri', [9661]], ['Xfr', [120091]], ['xfr', [120117]], ['xharr', [10231]], ['xhArr', [10234]], ['Xi', [926]], ['xi', [958]], ['xlarr', [10229]], ['xlArr', [10232]], ['xmap', [10236]], ['xnis', [8955]], ['xodot', [10752]], ['Xopf', [120143]], ['xopf', [120169]], ['xoplus', [10753]], ['xotime', [10754]], ['xrarr', [10230]], ['xrArr', [10233]], ['Xscr', [119987]], ['xscr', [120013]], ['xsqcup', [10758]], ['xuplus', [10756]], ['xutri', [9651]], ['xvee', [8897]], ['xwedge', [8896]], ['Yacute', [221]], ['yacute', [253]], ['YAcy', [1071]], ['yacy', [1103]], ['Ycirc', [374]], ['ycirc', [375]], ['Ycy', [1067]], ['ycy', [1099]], ['yen', [165]], ['Yfr', [120092]], ['yfr', [120118]], ['YIcy', [1031]], ['yicy', [1111]], ['Yopf', [120144]], ['yopf', [120170]], ['Yscr', [119988]], ['yscr', [120014]], ['YUcy', [1070]], ['yucy', [1102]], ['yuml', [255]], ['Yuml', [376]], ['Zacute', [377]], ['zacute', [378]], ['Zcaron', [381]], ['zcaron', [382]], ['Zcy', [1047]], ['zcy', [1079]], ['Zdot', [379]], ['zdot', [380]], ['zeetrf', [8488]], ['ZeroWidthSpace', [8203]], ['Zeta', [918]], ['zeta', [950]], ['zfr', [120119]], ['Zfr', [8488]], ['ZHcy', [1046]], ['zhcy', [1078]], ['zigrarr', [8669]], ['zopf', [120171]], ['Zopf', [8484]], ['Zscr', [119989]], ['zscr', [120015]], ['zwj', [8205]], ['zwnj', [8204]]];
    
    var alphaIndex = {};
    var charIndex = {};
    
    createIndexes(alphaIndex, charIndex);
    
    /**
     * @constructor
     */
    function Html5Entities() {}
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html5Entities.prototype.decode = function(str) {
        if (!str || !str.length) {
            return '';
        }
        return str.replace(/&(#?[\w\d]+);?/g, function(s, entity) {
            var chr;
            if (entity.charAt(0) === "#") {
                var code = entity.charAt(1) === 'x' ?
                    parseInt(entity.substr(2).toLowerCase(), 16) :
                    parseInt(entity.substr(1));
    
                if (!(isNaN(code) || code < -32768 || code > 65535)) {
                    chr = String.fromCharCode(code);
                }
            } else {
                chr = alphaIndex[entity];
            }
            return chr || s;
        });
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
     Html5Entities.decode = function(str) {
        return new Html5Entities().decode(str);
     };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html5Entities.prototype.encode = function(str) {
        if (!str || !str.length) {
            return '';
        }
        var strLength = str.length;
        var result = '';
        var i = 0;
        while (i < strLength) {
            var charInfo = charIndex[str.charCodeAt(i)];
            if (charInfo) {
                var alpha = charInfo[str.charCodeAt(i + 1)];
                if (alpha) {
                    i++;
                } else {
                    alpha = charInfo[''];
                }
                if (alpha) {
                    result += "&" + alpha + ";";
                    i++;
                    continue;
                }
            }
            result += str.charAt(i);
            i++;
        }
        return result;
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
     Html5Entities.encode = function(str) {
        return new Html5Entities().encode(str);
     };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html5Entities.prototype.encodeNonUTF = function(str) {
        if (!str || !str.length) {
            return '';
        }
        var strLength = str.length;
        var result = '';
        var i = 0;
        while (i < strLength) {
            var c = str.charCodeAt(i);
            var charInfo = charIndex[c];
            if (charInfo) {
                var alpha = charInfo[str.charCodeAt(i + 1)];
                if (alpha) {
                    i++;
                } else {
                    alpha = charInfo[''];
                }
                if (alpha) {
                    result += "&" + alpha + ";";
                    i++;
                    continue;
                }
            }
            if (c < 32 || c > 126) {
                result += '&#' + c + ';';
            } else {
                result += str.charAt(i);
            }
            i++;
        }
        return result;
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
     Html5Entities.encodeNonUTF = function(str) {
        return new Html5Entities().encodeNonUTF(str);
     };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html5Entities.prototype.encodeNonASCII = function(str) {
        if (!str || !str.length) {
            return '';
        }
        var strLength = str.length;
        var result = '';
        var i = 0;
        while (i < strLength) {
            var c = str.charCodeAt(i);
            if (c <= 255) {
                result += str[i++];
                continue;
            }
            result += '&#' + c + ';';
            i++
        }
        return result;
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
     Html5Entities.encodeNonASCII = function(str) {
        return new Html5Entities().encodeNonASCII(str);
     };
    
    /**
     * @param {Object} alphaIndex Passed by reference.
     * @param {Object} charIndex Passed by reference.
     */
    function createIndexes(alphaIndex, charIndex) {
        var i = ENTITIES.length;
        var _results = [];
        while (i--) {
            var e = ENTITIES[i];
            var alpha = e[0];
            var chars = e[1];
            var chr = chars[0];
            var addChar = (chr < 32 || chr > 126) || chr === 62 || chr === 60 || chr === 38 || chr === 34 || chr === 39;
            var charInfo;
            if (addChar) {
                charInfo = charIndex[chr] = charIndex[chr] || {};
            }
            if (chars[1]) {
                var chr2 = chars[1];
                alphaIndex[alpha] = String.fromCharCode(chr) + String.fromCharCode(chr2);
                _results.push(addChar && (charInfo[chr2] = alpha));
            } else {
                alphaIndex[alpha] = String.fromCharCode(chr);
                _results.push(addChar && (charInfo[''] = alpha));
            }
        }
    }
    
    module.exports = Html5Entities;
    
    
    /***/ }),
    /* 9 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCRipple; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_component__ = __webpack_require__(2);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__material_dom_index__ = __webpack_require__(46);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__foundation__ = __webpack_require__(4);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__util__ = __webpack_require__(3);
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    
    
    var MDCRipple = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCRipple, _super);
        function MDCRipple() {
            var _this = _super !== null && _super.apply(this, arguments) || this;
            _this.disabled = false;
            return _this;
        }
        MDCRipple.attachTo = function (root, opts) {
            if (opts === void 0) { opts = { isUnbounded: undefined }; }
            var ripple = new MDCRipple(root);
            // Only override unbounded behavior if option is explicitly specified
            if (opts.isUnbounded !== undefined) {
                ripple.unbounded = opts.isUnbounded;
            }
            return ripple;
        };
        MDCRipple.createAdapter = function (instance) {
            return {
                addClass: function (className) { return instance.root_.classList.add(className); },
                browserSupportsCssVars: function () { return __WEBPACK_IMPORTED_MODULE_4__util__["supportsCssVariables"](window); },
                computeBoundingRect: function () { return instance.root_.getBoundingClientRect(); },
                containsEventTarget: function (target) { return instance.root_.contains(target); },
                deregisterDocumentInteractionHandler: function (evtType, handler) {
                    return document.documentElement.removeEventListener(evtType, handler, __WEBPACK_IMPORTED_MODULE_4__util__["applyPassive"]());
                },
                deregisterInteractionHandler: function (evtType, handler) {
                    return instance.root_.removeEventListener(evtType, handler, __WEBPACK_IMPORTED_MODULE_4__util__["applyPassive"]());
                },
                deregisterResizeHandler: function (handler) { return window.removeEventListener('resize', handler); },
                getWindowPageOffset: function () { return ({ x: window.pageXOffset, y: window.pageYOffset }); },
                isSurfaceActive: function () { return __WEBPACK_IMPORTED_MODULE_2__material_dom_index__["a" /* ponyfill */].matches(instance.root_, ':active'); },
                isSurfaceDisabled: function () { return Boolean(instance.disabled); },
                isUnbounded: function () { return Boolean(instance.unbounded); },
                registerDocumentInteractionHandler: function (evtType, handler) {
                    return document.documentElement.addEventListener(evtType, handler, __WEBPACK_IMPORTED_MODULE_4__util__["applyPassive"]());
                },
                registerInteractionHandler: function (evtType, handler) {
                    return instance.root_.addEventListener(evtType, handler, __WEBPACK_IMPORTED_MODULE_4__util__["applyPassive"]());
                },
                registerResizeHandler: function (handler) { return window.addEventListener('resize', handler); },
                removeClass: function (className) { return instance.root_.classList.remove(className); },
                updateCssVariable: function (varName, value) { return instance.root_.style.setProperty(varName, value); },
            };
        };
        Object.defineProperty(MDCRipple.prototype, "unbounded", {
            get: function () {
                return Boolean(this.unbounded_);
            },
            set: function (unbounded) {
                this.unbounded_ = Boolean(unbounded);
                this.setUnbounded_();
            },
            enumerable: true,
            configurable: true
        });
        MDCRipple.prototype.activate = function () {
            this.foundation_.activate();
        };
        MDCRipple.prototype.deactivate = function () {
            this.foundation_.deactivate();
        };
        MDCRipple.prototype.layout = function () {
            this.foundation_.layout();
        };
        MDCRipple.prototype.getDefaultFoundation = function () {
            return new __WEBPACK_IMPORTED_MODULE_3__foundation__["a" /* MDCRippleFoundation */](MDCRipple.createAdapter(this));
        };
        MDCRipple.prototype.initialSyncWithDOM = function () {
            var root = this.root_;
            this.unbounded = 'mdcRippleIsUnbounded' in root.dataset;
        };
        /**
         * Closure Compiler throws an access control error when directly accessing a
         * protected or private property inside a getter/setter, like unbounded above.
         * By accessing the protected property inside a method, we solve that problem.
         * That's why this function exists.
         */
        MDCRipple.prototype.setUnbounded_ = function () {
            this.foundation_.setUnbounded(Boolean(this.unbounded_));
        };
        return MDCRipple;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_component__["a" /* MDCComponent */]));
    
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 10 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
    /* harmony export (immutable) */ __webpack_exports__["closest"] = closest;
    /* harmony export (immutable) */ __webpack_exports__["matches"] = matches;
    /**
     * @license
     * Copyright 2018 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    /**
     * @fileoverview A "ponyfill" is a polyfill that doesn't modify the global prototype chain.
     * This makes ponyfills safer than traditional polyfills, especially for libraries like MDC.
     */
    function closest(element, selector) {
        if (element.closest) {
            return element.closest(selector);
        }
        var el = element;
        while (el) {
            if (matches(el, selector)) {
                return el;
            }
            el = el.parentElement;
        }
        return null;
    }
    function matches(element, selector) {
        var nativeMatches = element.matches
            || element.webkitMatchesSelector
            || element.msMatchesSelector;
        return nativeMatches.call(element, selector);
    }
    //# sourceMappingURL=ponyfill.js.map
    
    /***/ }),
    /* 11 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCLineRippleFoundation; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_foundation__ = __webpack_require__(1);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constants__ = __webpack_require__(55);
    /**
     * @license
     * Copyright 2018 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCLineRippleFoundation = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCLineRippleFoundation, _super);
        function MDCLineRippleFoundation(adapter) {
            var _this = _super.call(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, MDCLineRippleFoundation.defaultAdapter, adapter)) || this;
            _this.transitionEndHandler_ = function (evt) { return _this.handleTransitionEnd(evt); };
            return _this;
        }
        Object.defineProperty(MDCLineRippleFoundation, "cssClasses", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCLineRippleFoundation, "defaultAdapter", {
            /**
             * See {@link MDCLineRippleAdapter} for typing information on parameters and return types.
             */
            get: function () {
                // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
                return {
                    addClass: function () { return undefined; },
                    removeClass: function () { return undefined; },
                    hasClass: function () { return false; },
                    setStyle: function () { return undefined; },
                    registerEventHandler: function () { return undefined; },
                    deregisterEventHandler: function () { return undefined; },
                };
                // tslint:enable:object-literal-sort-keys
            },
            enumerable: true,
            configurable: true
        });
        MDCLineRippleFoundation.prototype.init = function () {
            this.adapter_.registerEventHandler('transitionend', this.transitionEndHandler_);
        };
        MDCLineRippleFoundation.prototype.destroy = function () {
            this.adapter_.deregisterEventHandler('transitionend', this.transitionEndHandler_);
        };
        MDCLineRippleFoundation.prototype.activate = function () {
            this.adapter_.removeClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].LINE_RIPPLE_DEACTIVATING);
            this.adapter_.addClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].LINE_RIPPLE_ACTIVE);
        };
        MDCLineRippleFoundation.prototype.setRippleCenter = function (xCoordinate) {
            this.adapter_.setStyle('transform-origin', xCoordinate + "px center");
        };
        MDCLineRippleFoundation.prototype.deactivate = function () {
            this.adapter_.addClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].LINE_RIPPLE_DEACTIVATING);
        };
        MDCLineRippleFoundation.prototype.handleTransitionEnd = function (evt) {
            // Wait for the line ripple to be either transparent or opaque
            // before emitting the animation end event
            var isDeactivating = this.adapter_.hasClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].LINE_RIPPLE_DEACTIVATING);
            if (evt.propertyName === 'opacity') {
                if (isDeactivating) {
                    this.adapter_.removeClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].LINE_RIPPLE_ACTIVE);
                    this.adapter_.removeClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].LINE_RIPPLE_DEACTIVATING);
                }
            }
        };
        return MDCLineRippleFoundation;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_foundation__["a" /* MDCFoundation */]));
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCLineRippleFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 12 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return cssClasses; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return numbers; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return strings; });
    /**
     * @license
     * Copyright 2018 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var strings = {
        NOTCH_ELEMENT_SELECTOR: '.mdc-notched-outline__notch',
    };
    var numbers = {
        // This should stay in sync with $mdc-notched-outline-padding * 2.
        NOTCH_ELEMENT_PADDING: 8,
    };
    var cssClasses = {
        NO_LABEL: 'mdc-notched-outline--no-label',
        OUTLINE_NOTCHED: 'mdc-notched-outline--notched',
        OUTLINE_UPGRADED: 'mdc-notched-outline--upgraded',
    };
    
    //# sourceMappingURL=constants.js.map
    
    /***/ }),
    /* 13 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCNotchedOutlineFoundation; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_foundation__ = __webpack_require__(1);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constants__ = __webpack_require__(12);
    /**
     * @license
     * Copyright 2017 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCNotchedOutlineFoundation = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCNotchedOutlineFoundation, _super);
        function MDCNotchedOutlineFoundation(adapter) {
            return _super.call(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, MDCNotchedOutlineFoundation.defaultAdapter, adapter)) || this;
        }
        Object.defineProperty(MDCNotchedOutlineFoundation, "strings", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["c" /* strings */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCNotchedOutlineFoundation, "cssClasses", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCNotchedOutlineFoundation, "numbers", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["b" /* numbers */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCNotchedOutlineFoundation, "defaultAdapter", {
            /**
             * See {@link MDCNotchedOutlineAdapter} for typing information on parameters and return types.
             */
            get: function () {
                // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
                return {
                    addClass: function () { return undefined; },
                    removeClass: function () { return undefined; },
                    setNotchWidthProperty: function () { return undefined; },
                    removeNotchWidthProperty: function () { return undefined; },
                };
                // tslint:enable:object-literal-sort-keys
            },
            enumerable: true,
            configurable: true
        });
        /**
         * Adds the outline notched selector and updates the notch width calculated based off of notchWidth.
         */
        MDCNotchedOutlineFoundation.prototype.notch = function (notchWidth) {
            var OUTLINE_NOTCHED = MDCNotchedOutlineFoundation.cssClasses.OUTLINE_NOTCHED;
            if (notchWidth > 0) {
                notchWidth += __WEBPACK_IMPORTED_MODULE_2__constants__["b" /* numbers */].NOTCH_ELEMENT_PADDING; // Add padding from left/right.
            }
            this.adapter_.setNotchWidthProperty(notchWidth);
            this.adapter_.addClass(OUTLINE_NOTCHED);
        };
        /**
         * Removes notched outline selector to close the notch in the outline.
         */
        MDCNotchedOutlineFoundation.prototype.closeNotch = function () {
            var OUTLINE_NOTCHED = MDCNotchedOutlineFoundation.cssClasses.OUTLINE_NOTCHED;
            this.adapter_.removeClass(OUTLINE_NOTCHED);
            this.adapter_.removeNotchWidthProperty();
        };
        return MDCNotchedOutlineFoundation;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_foundation__["a" /* MDCFoundation */]));
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCNotchedOutlineFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 14 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__component__ = __webpack_require__(58);
    /* harmony namespace reexport (by used) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__component__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__foundation__ = __webpack_require__(15);
    /* harmony namespace reexport (by used) */ __webpack_require__.d(__webpack_exports__, "b", function() { return __WEBPACK_IMPORTED_MODULE_1__foundation__["a"]; });
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 15 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCTextFieldCharacterCounterFoundation; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_foundation__ = __webpack_require__(1);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constants__ = __webpack_require__(59);
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCTextFieldCharacterCounterFoundation = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCTextFieldCharacterCounterFoundation, _super);
        function MDCTextFieldCharacterCounterFoundation(adapter) {
            return _super.call(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, MDCTextFieldCharacterCounterFoundation.defaultAdapter, adapter)) || this;
        }
        Object.defineProperty(MDCTextFieldCharacterCounterFoundation, "cssClasses", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldCharacterCounterFoundation, "strings", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["b" /* strings */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldCharacterCounterFoundation, "defaultAdapter", {
            /**
             * See {@link MDCTextFieldCharacterCounterAdapter} for typing information on parameters and return types.
             */
            get: function () {
                return {
                    setContent: function () { return undefined; },
                };
            },
            enumerable: true,
            configurable: true
        });
        MDCTextFieldCharacterCounterFoundation.prototype.setCounterValue = function (currentLength, maxLength) {
            currentLength = Math.min(currentLength, maxLength);
            this.adapter_.setContent(currentLength + " / " + maxLength);
        };
        return MDCTextFieldCharacterCounterFoundation;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_foundation__["a" /* MDCFoundation */]));
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCTextFieldCharacterCounterFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 16 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return cssClasses; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "e", function() { return strings; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "d", function() { return numbers; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return VALIDATION_ATTR_WHITELIST; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ALWAYS_FLOAT_TYPES; });
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var strings = {
        ARIA_CONTROLS: 'aria-controls',
        ICON_SELECTOR: '.mdc-text-field__icon',
        INPUT_SELECTOR: '.mdc-text-field__input',
        LABEL_SELECTOR: '.mdc-floating-label',
        LINE_RIPPLE_SELECTOR: '.mdc-line-ripple',
        OUTLINE_SELECTOR: '.mdc-notched-outline',
    };
    var cssClasses = {
        DENSE: 'mdc-text-field--dense',
        DISABLED: 'mdc-text-field--disabled',
        FOCUSED: 'mdc-text-field--focused',
        HELPER_LINE: 'mdc-text-field-helper-line',
        INVALID: 'mdc-text-field--invalid',
        OUTLINED: 'mdc-text-field--outlined',
        ROOT: 'mdc-text-field',
        TEXTAREA: 'mdc-text-field--textarea',
        WITH_LEADING_ICON: 'mdc-text-field--with-leading-icon',
    };
    var numbers = {
        DENSE_LABEL_SCALE: 0.923,
        LABEL_SCALE: 0.75,
    };
    /**
     * Whitelist based off of https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/HTML5/Constraint_validation
     * under the "Validation-related attributes" section.
     */
    var VALIDATION_ATTR_WHITELIST = [
        'pattern', 'min', 'max', 'required', 'step', 'minlength', 'maxlength',
    ];
    /**
     * Label should always float for these types as they show some UI even if value is empty.
     */
    var ALWAYS_FLOAT_TYPES = [
        'color', 'date', 'datetime-local', 'month', 'range', 'time', 'week',
    ];
    
    //# sourceMappingURL=constants.js.map
    
    /***/ }),
    /* 17 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCTextFieldFoundation; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_foundation__ = __webpack_require__(1);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constants__ = __webpack_require__(16);
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var POINTERDOWN_EVENTS = ['mousedown', 'touchstart'];
    var INTERACTION_EVENTS = ['click', 'keydown'];
    var MDCTextFieldFoundation = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCTextFieldFoundation, _super);
        /**
         * @param adapter
         * @param foundationMap Map from subcomponent names to their subfoundations.
         */
        function MDCTextFieldFoundation(adapter, foundationMap) {
            if (foundationMap === void 0) { foundationMap = {}; }
            var _this = _super.call(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, MDCTextFieldFoundation.defaultAdapter, adapter)) || this;
            _this.isFocused_ = false;
            _this.receivedUserInput_ = false;
            _this.isValid_ = true;
            _this.useNativeValidation_ = true;
            _this.helperText_ = foundationMap.helperText;
            _this.characterCounter_ = foundationMap.characterCounter;
            _this.leadingIcon_ = foundationMap.leadingIcon;
            _this.trailingIcon_ = foundationMap.trailingIcon;
            _this.inputFocusHandler_ = function () { return _this.activateFocus(); };
            _this.inputBlurHandler_ = function () { return _this.deactivateFocus(); };
            _this.inputInputHandler_ = function () { return _this.handleInput(); };
            _this.setPointerXOffset_ = function (evt) { return _this.setTransformOrigin(evt); };
            _this.textFieldInteractionHandler_ = function () { return _this.handleTextFieldInteraction(); };
            _this.validationAttributeChangeHandler_ = function (attributesList) { return _this.handleValidationAttributeChange(attributesList); };
            return _this;
        }
        Object.defineProperty(MDCTextFieldFoundation, "cssClasses", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["c" /* cssClasses */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldFoundation, "strings", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["e" /* strings */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldFoundation, "numbers", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["d" /* numbers */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldFoundation.prototype, "shouldAlwaysFloat_", {
            get: function () {
                var type = this.getNativeInput_().type;
                return __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* ALWAYS_FLOAT_TYPES */].indexOf(type) >= 0;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldFoundation.prototype, "shouldFloat", {
            get: function () {
                return this.shouldAlwaysFloat_ || this.isFocused_ || Boolean(this.getValue()) || this.isBadInput_();
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldFoundation.prototype, "shouldShake", {
            get: function () {
                return !this.isFocused_ && !this.isValid() && Boolean(this.getValue());
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldFoundation, "defaultAdapter", {
            /**
             * See {@link MDCTextFieldAdapter} for typing information on parameters and return types.
             */
            get: function () {
                // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
                return {
                    addClass: function () { return undefined; },
                    removeClass: function () { return undefined; },
                    hasClass: function () { return true; },
                    registerTextFieldInteractionHandler: function () { return undefined; },
                    deregisterTextFieldInteractionHandler: function () { return undefined; },
                    registerInputInteractionHandler: function () { return undefined; },
                    deregisterInputInteractionHandler: function () { return undefined; },
                    registerValidationAttributeChangeHandler: function () { return new MutationObserver(function () { return undefined; }); },
                    deregisterValidationAttributeChangeHandler: function () { return undefined; },
                    getNativeInput: function () { return null; },
                    isFocused: function () { return false; },
                    activateLineRipple: function () { return undefined; },
                    deactivateLineRipple: function () { return undefined; },
                    setLineRippleTransformOrigin: function () { return undefined; },
                    shakeLabel: function () { return undefined; },
                    floatLabel: function () { return undefined; },
                    hasLabel: function () { return false; },
                    getLabelWidth: function () { return 0; },
                    hasOutline: function () { return false; },
                    notchOutline: function () { return undefined; },
                    closeOutline: function () { return undefined; },
                };
                // tslint:enable:object-literal-sort-keys
            },
            enumerable: true,
            configurable: true
        });
        MDCTextFieldFoundation.prototype.init = function () {
            var _this = this;
            if (this.adapter_.isFocused()) {
                this.inputFocusHandler_();
            }
            else if (this.adapter_.hasLabel() && this.shouldFloat) {
                this.notchOutline(true);
                this.adapter_.floatLabel(true);
            }
            this.adapter_.registerInputInteractionHandler('focus', this.inputFocusHandler_);
            this.adapter_.registerInputInteractionHandler('blur', this.inputBlurHandler_);
            this.adapter_.registerInputInteractionHandler('input', this.inputInputHandler_);
            POINTERDOWN_EVENTS.forEach(function (evtType) {
                _this.adapter_.registerInputInteractionHandler(evtType, _this.setPointerXOffset_);
            });
            INTERACTION_EVENTS.forEach(function (evtType) {
                _this.adapter_.registerTextFieldInteractionHandler(evtType, _this.textFieldInteractionHandler_);
            });
            this.validationObserver_ =
                this.adapter_.registerValidationAttributeChangeHandler(this.validationAttributeChangeHandler_);
            this.setCharacterCounter_(this.getValue().length);
        };
        MDCTextFieldFoundation.prototype.destroy = function () {
            var _this = this;
            this.adapter_.deregisterInputInteractionHandler('focus', this.inputFocusHandler_);
            this.adapter_.deregisterInputInteractionHandler('blur', this.inputBlurHandler_);
            this.adapter_.deregisterInputInteractionHandler('input', this.inputInputHandler_);
            POINTERDOWN_EVENTS.forEach(function (evtType) {
                _this.adapter_.deregisterInputInteractionHandler(evtType, _this.setPointerXOffset_);
            });
            INTERACTION_EVENTS.forEach(function (evtType) {
                _this.adapter_.deregisterTextFieldInteractionHandler(evtType, _this.textFieldInteractionHandler_);
            });
            this.adapter_.deregisterValidationAttributeChangeHandler(this.validationObserver_);
        };
        /**
         * Handles user interactions with the Text Field.
         */
        MDCTextFieldFoundation.prototype.handleTextFieldInteraction = function () {
            var nativeInput = this.adapter_.getNativeInput();
            if (nativeInput && nativeInput.disabled) {
                return;
            }
            this.receivedUserInput_ = true;
        };
        /**
         * Handles validation attribute changes
         */
        MDCTextFieldFoundation.prototype.handleValidationAttributeChange = function (attributesList) {
            var _this = this;
            attributesList.some(function (attributeName) {
                if (__WEBPACK_IMPORTED_MODULE_2__constants__["b" /* VALIDATION_ATTR_WHITELIST */].indexOf(attributeName) > -1) {
                    _this.styleValidity_(true);
                    return true;
                }
                return false;
            });
            if (attributesList.indexOf('maxlength') > -1) {
                this.setCharacterCounter_(this.getValue().length);
            }
        };
        /**
         * Opens/closes the notched outline.
         */
        MDCTextFieldFoundation.prototype.notchOutline = function (openNotch) {
            if (!this.adapter_.hasOutline()) {
                return;
            }
            if (openNotch) {
                var isDense = this.adapter_.hasClass(__WEBPACK_IMPORTED_MODULE_2__constants__["c" /* cssClasses */].DENSE);
                var labelScale = isDense ? __WEBPACK_IMPORTED_MODULE_2__constants__["d" /* numbers */].DENSE_LABEL_SCALE : __WEBPACK_IMPORTED_MODULE_2__constants__["d" /* numbers */].LABEL_SCALE;
                var labelWidth = this.adapter_.getLabelWidth() * labelScale;
                this.adapter_.notchOutline(labelWidth);
            }
            else {
                this.adapter_.closeOutline();
            }
        };
        /**
         * Activates the text field focus state.
         */
        MDCTextFieldFoundation.prototype.activateFocus = function () {
            this.isFocused_ = true;
            this.styleFocused_(this.isFocused_);
            this.adapter_.activateLineRipple();
            if (this.adapter_.hasLabel()) {
                this.notchOutline(this.shouldFloat);
                this.adapter_.floatLabel(this.shouldFloat);
                this.adapter_.shakeLabel(this.shouldShake);
            }
            if (this.helperText_) {
                this.helperText_.showToScreenReader();
            }
        };
        /**
         * Sets the line ripple's transform origin, so that the line ripple activate
         * animation will animate out from the user's click location.
         */
        MDCTextFieldFoundation.prototype.setTransformOrigin = function (evt) {
            var touches = evt.touches;
            var targetEvent = touches ? touches[0] : evt;
            var targetClientRect = targetEvent.target.getBoundingClientRect();
            var normalizedX = targetEvent.clientX - targetClientRect.left;
            this.adapter_.setLineRippleTransformOrigin(normalizedX);
        };
        /**
         * Handles input change of text input and text area.
         */
        MDCTextFieldFoundation.prototype.handleInput = function () {
            this.autoCompleteFocus();
            this.setCharacterCounter_(this.getValue().length);
        };
        /**
         * Activates the Text Field's focus state in cases when the input value
         * changes without user input (e.g. programmatically).
         */
        MDCTextFieldFoundation.prototype.autoCompleteFocus = function () {
            if (!this.receivedUserInput_) {
                this.activateFocus();
            }
        };
        /**
         * Deactivates the Text Field's focus state.
         */
        MDCTextFieldFoundation.prototype.deactivateFocus = function () {
            this.isFocused_ = false;
            this.adapter_.deactivateLineRipple();
            var isValid = this.isValid();
            this.styleValidity_(isValid);
            this.styleFocused_(this.isFocused_);
            if (this.adapter_.hasLabel()) {
                this.notchOutline(this.shouldFloat);
                this.adapter_.floatLabel(this.shouldFloat);
                this.adapter_.shakeLabel(this.shouldShake);
            }
            if (!this.shouldFloat) {
                this.receivedUserInput_ = false;
            }
        };
        MDCTextFieldFoundation.prototype.getValue = function () {
            return this.getNativeInput_().value;
        };
        /**
         * @param value The value to set on the input Element.
         */
        MDCTextFieldFoundation.prototype.setValue = function (value) {
            // Prevent Safari from moving the caret to the end of the input when the value has not changed.
            if (this.getValue() !== value) {
                this.getNativeInput_().value = value;
                this.setCharacterCounter_(value.length);
            }
            var isValid = this.isValid();
            this.styleValidity_(isValid);
            if (this.adapter_.hasLabel()) {
                this.notchOutline(this.shouldFloat);
                this.adapter_.floatLabel(this.shouldFloat);
                this.adapter_.shakeLabel(this.shouldShake);
            }
        };
        /**
         * @return The custom validity state, if set; otherwise, the result of a native validity check.
         */
        MDCTextFieldFoundation.prototype.isValid = function () {
            return this.useNativeValidation_
                ? this.isNativeInputValid_() : this.isValid_;
        };
        /**
         * @param isValid Sets the custom validity state of the Text Field.
         */
        MDCTextFieldFoundation.prototype.setValid = function (isValid) {
            this.isValid_ = isValid;
            this.styleValidity_(isValid);
            var shouldShake = !isValid && !this.isFocused_;
            if (this.adapter_.hasLabel()) {
                this.adapter_.shakeLabel(shouldShake);
            }
        };
        /**
         * Enables or disables the use of native validation. Use this for custom validation.
         * @param useNativeValidation Set this to false to ignore native input validation.
         */
        MDCTextFieldFoundation.prototype.setUseNativeValidation = function (useNativeValidation) {
            this.useNativeValidation_ = useNativeValidation;
        };
        MDCTextFieldFoundation.prototype.isDisabled = function () {
            return this.getNativeInput_().disabled;
        };
        /**
         * @param disabled Sets the text-field disabled or enabled.
         */
        MDCTextFieldFoundation.prototype.setDisabled = function (disabled) {
            this.getNativeInput_().disabled = disabled;
            this.styleDisabled_(disabled);
        };
        /**
         * @param content Sets the content of the helper text.
         */
        MDCTextFieldFoundation.prototype.setHelperTextContent = function (content) {
            if (this.helperText_) {
                this.helperText_.setContent(content);
            }
        };
        /**
         * Sets the aria label of the leading icon.
         */
        MDCTextFieldFoundation.prototype.setLeadingIconAriaLabel = function (label) {
            if (this.leadingIcon_) {
                this.leadingIcon_.setAriaLabel(label);
            }
        };
        /**
         * Sets the text content of the leading icon.
         */
        MDCTextFieldFoundation.prototype.setLeadingIconContent = function (content) {
            if (this.leadingIcon_) {
                this.leadingIcon_.setContent(content);
            }
        };
        /**
         * Sets the aria label of the trailing icon.
         */
        MDCTextFieldFoundation.prototype.setTrailingIconAriaLabel = function (label) {
            if (this.trailingIcon_) {
                this.trailingIcon_.setAriaLabel(label);
            }
        };
        /**
         * Sets the text content of the trailing icon.
         */
        MDCTextFieldFoundation.prototype.setTrailingIconContent = function (content) {
            if (this.trailingIcon_) {
                this.trailingIcon_.setContent(content);
            }
        };
        /**
         * Sets character counter values that shows characters used and the total character limit.
         */
        MDCTextFieldFoundation.prototype.setCharacterCounter_ = function (currentLength) {
            if (!this.characterCounter_) {
                return;
            }
            var maxLength = this.getNativeInput_().maxLength;
            if (maxLength === -1) {
                throw new Error('MDCTextFieldFoundation: Expected maxlength html property on text input or textarea.');
            }
            this.characterCounter_.setCounterValue(currentLength, maxLength);
        };
        /**
         * @return True if the Text Field input fails in converting the user-supplied value.
         */
        MDCTextFieldFoundation.prototype.isBadInput_ = function () {
            // The badInput property is not supported in IE 11 💩.
            return this.getNativeInput_().validity.badInput || false;
        };
        /**
         * @return The result of native validity checking (ValidityState.valid).
         */
        MDCTextFieldFoundation.prototype.isNativeInputValid_ = function () {
            return this.getNativeInput_().validity.valid;
        };
        /**
         * Styles the component based on the validity state.
         */
        MDCTextFieldFoundation.prototype.styleValidity_ = function (isValid) {
            var INVALID = MDCTextFieldFoundation.cssClasses.INVALID;
            if (isValid) {
                this.adapter_.removeClass(INVALID);
            }
            else {
                this.adapter_.addClass(INVALID);
            }
            if (this.helperText_) {
                this.helperText_.setValidity(isValid);
            }
        };
        /**
         * Styles the component based on the focused state.
         */
        MDCTextFieldFoundation.prototype.styleFocused_ = function (isFocused) {
            var FOCUSED = MDCTextFieldFoundation.cssClasses.FOCUSED;
            if (isFocused) {
                this.adapter_.addClass(FOCUSED);
            }
            else {
                this.adapter_.removeClass(FOCUSED);
            }
        };
        /**
         * Styles the component based on the disabled state.
         */
        MDCTextFieldFoundation.prototype.styleDisabled_ = function (isDisabled) {
            var _a = MDCTextFieldFoundation.cssClasses, DISABLED = _a.DISABLED, INVALID = _a.INVALID;
            if (isDisabled) {
                this.adapter_.addClass(DISABLED);
                this.adapter_.removeClass(INVALID);
            }
            else {
                this.adapter_.removeClass(DISABLED);
            }
            if (this.leadingIcon_) {
                this.leadingIcon_.setDisabled(isDisabled);
            }
            if (this.trailingIcon_) {
                this.trailingIcon_.setDisabled(isDisabled);
            }
        };
        /**
         * @return The native text input element from the host environment, or an object with the same shape for unit tests.
         */
        MDCTextFieldFoundation.prototype.getNativeInput_ = function () {
            // this.adapter_ may be undefined in foundation unit tests. This happens when testdouble is creating a mock object
            // and invokes the shouldShake/shouldFloat getters (which in turn call getValue(), which calls this method) before
            // init() has been called from the MDCTextField constructor. To work around that issue, we return a dummy object.
            var nativeInput = this.adapter_ ? this.adapter_.getNativeInput() : null;
            return nativeInput || {
                disabled: false,
                maxLength: -1,
                type: 'input',
                validity: {
                    badInput: false,
                    valid: true,
                },
                value: '',
            };
        };
        return MDCTextFieldFoundation;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_foundation__["a" /* MDCFoundation */]));
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCTextFieldFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 18 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__component__ = __webpack_require__(60);
    /* harmony namespace reexport (by used) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__component__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__foundation__ = __webpack_require__(19);
    /* harmony namespace reexport (by used) */ __webpack_require__.d(__webpack_exports__, "b", function() { return __WEBPACK_IMPORTED_MODULE_1__foundation__["a"]; });
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 19 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCTextFieldHelperTextFoundation; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_foundation__ = __webpack_require__(1);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constants__ = __webpack_require__(61);
    /**
     * @license
     * Copyright 2017 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCTextFieldHelperTextFoundation = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCTextFieldHelperTextFoundation, _super);
        function MDCTextFieldHelperTextFoundation(adapter) {
            return _super.call(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, MDCTextFieldHelperTextFoundation.defaultAdapter, adapter)) || this;
        }
        Object.defineProperty(MDCTextFieldHelperTextFoundation, "cssClasses", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldHelperTextFoundation, "strings", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["b" /* strings */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldHelperTextFoundation, "defaultAdapter", {
            /**
             * See {@link MDCTextFieldHelperTextAdapter} for typing information on parameters and return types.
             */
            get: function () {
                // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
                return {
                    addClass: function () { return undefined; },
                    removeClass: function () { return undefined; },
                    hasClass: function () { return false; },
                    setAttr: function () { return undefined; },
                    removeAttr: function () { return undefined; },
                    setContent: function () { return undefined; },
                };
                // tslint:enable:object-literal-sort-keys
            },
            enumerable: true,
            configurable: true
        });
        /**
         * Sets the content of the helper text field.
         */
        MDCTextFieldHelperTextFoundation.prototype.setContent = function (content) {
            this.adapter_.setContent(content);
        };
        /**
         * @param isPersistent Sets the persistency of the helper text.
         */
        MDCTextFieldHelperTextFoundation.prototype.setPersistent = function (isPersistent) {
            if (isPersistent) {
                this.adapter_.addClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].HELPER_TEXT_PERSISTENT);
            }
            else {
                this.adapter_.removeClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].HELPER_TEXT_PERSISTENT);
            }
        };
        /**
         * @param isValidation True to make the helper text act as an error validation message.
         */
        MDCTextFieldHelperTextFoundation.prototype.setValidation = function (isValidation) {
            if (isValidation) {
                this.adapter_.addClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].HELPER_TEXT_VALIDATION_MSG);
            }
            else {
                this.adapter_.removeClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].HELPER_TEXT_VALIDATION_MSG);
            }
        };
        /**
         * Makes the helper text visible to the screen reader.
         */
        MDCTextFieldHelperTextFoundation.prototype.showToScreenReader = function () {
            this.adapter_.removeAttr(__WEBPACK_IMPORTED_MODULE_2__constants__["b" /* strings */].ARIA_HIDDEN);
        };
        /**
         * Sets the validity of the helper text based on the input validity.
         */
        MDCTextFieldHelperTextFoundation.prototype.setValidity = function (inputIsValid) {
            var helperTextIsPersistent = this.adapter_.hasClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].HELPER_TEXT_PERSISTENT);
            var helperTextIsValidationMsg = this.adapter_.hasClass(__WEBPACK_IMPORTED_MODULE_2__constants__["a" /* cssClasses */].HELPER_TEXT_VALIDATION_MSG);
            var validationMsgNeedsDisplay = helperTextIsValidationMsg && !inputIsValid;
            if (validationMsgNeedsDisplay) {
                this.adapter_.setAttr(__WEBPACK_IMPORTED_MODULE_2__constants__["b" /* strings */].ROLE, 'alert');
            }
            else {
                this.adapter_.removeAttr(__WEBPACK_IMPORTED_MODULE_2__constants__["b" /* strings */].ROLE);
            }
            if (!helperTextIsPersistent && !validationMsgNeedsDisplay) {
                this.hide_();
            }
        };
        /**
         * Hides the help text from screen readers.
         */
        MDCTextFieldHelperTextFoundation.prototype.hide_ = function () {
            this.adapter_.setAttr(__WEBPACK_IMPORTED_MODULE_2__constants__["b" /* strings */].ARIA_HIDDEN, 'true');
        };
        return MDCTextFieldHelperTextFoundation;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_foundation__["a" /* MDCFoundation */]));
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCTextFieldHelperTextFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 20 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCTextFieldIconFoundation; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_foundation__ = __webpack_require__(1);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__constants__ = __webpack_require__(63);
    /**
     * @license
     * Copyright 2017 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var INTERACTION_EVENTS = ['click', 'keydown'];
    var MDCTextFieldIconFoundation = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCTextFieldIconFoundation, _super);
        function MDCTextFieldIconFoundation(adapter) {
            var _this = _super.call(this, __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, MDCTextFieldIconFoundation.defaultAdapter, adapter)) || this;
            _this.savedTabIndex_ = null;
            _this.interactionHandler_ = function (evt) { return _this.handleInteraction(evt); };
            return _this;
        }
        Object.defineProperty(MDCTextFieldIconFoundation, "strings", {
            get: function () {
                return __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* strings */];
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextFieldIconFoundation, "defaultAdapter", {
            /**
             * See {@link MDCTextFieldIconAdapter} for typing information on parameters and return types.
             */
            get: function () {
                // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
                return {
                    getAttr: function () { return null; },
                    setAttr: function () { return undefined; },
                    removeAttr: function () { return undefined; },
                    setContent: function () { return undefined; },
                    registerInteractionHandler: function () { return undefined; },
                    deregisterInteractionHandler: function () { return undefined; },
                    notifyIconAction: function () { return undefined; },
                };
                // tslint:enable:object-literal-sort-keys
            },
            enumerable: true,
            configurable: true
        });
        MDCTextFieldIconFoundation.prototype.init = function () {
            var _this = this;
            this.savedTabIndex_ = this.adapter_.getAttr('tabindex');
            INTERACTION_EVENTS.forEach(function (evtType) {
                _this.adapter_.registerInteractionHandler(evtType, _this.interactionHandler_);
            });
        };
        MDCTextFieldIconFoundation.prototype.destroy = function () {
            var _this = this;
            INTERACTION_EVENTS.forEach(function (evtType) {
                _this.adapter_.deregisterInteractionHandler(evtType, _this.interactionHandler_);
            });
        };
        MDCTextFieldIconFoundation.prototype.setDisabled = function (disabled) {
            if (!this.savedTabIndex_) {
                return;
            }
            if (disabled) {
                this.adapter_.setAttr('tabindex', '-1');
                this.adapter_.removeAttr('role');
            }
            else {
                this.adapter_.setAttr('tabindex', this.savedTabIndex_);
                this.adapter_.setAttr('role', __WEBPACK_IMPORTED_MODULE_2__constants__["a" /* strings */].ICON_ROLE);
            }
        };
        MDCTextFieldIconFoundation.prototype.setAriaLabel = function (label) {
            this.adapter_.setAttr('aria-label', label);
        };
        MDCTextFieldIconFoundation.prototype.setContent = function (content) {
            this.adapter_.setContent(content);
        };
        MDCTextFieldIconFoundation.prototype.handleInteraction = function (evt) {
            var isEnterKey = evt.key === 'Enter' || evt.keyCode === 13;
            if (evt.type === 'click' || isEnterKey) {
                this.adapter_.notifyIconAction();
            }
        };
        return MDCTextFieldIconFoundation;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_foundation__["a" /* MDCFoundation */]));
    
    // tslint:disable-next-line:no-default-export Needed for backward compatibility with MDC Web v0.44.0 and earlier.
    /* unused harmony default export */ var _unused_webpack_default_export = (MDCTextFieldIconFoundation);
    //# sourceMappingURL=foundation.js.map
    
    /***/ }),
    /* 21 */
    /***/ (function(module, exports, __webpack_require__) {
    
    __webpack_require__(22);
    module.exports = __webpack_require__(44);
    
    
    /***/ }),
    /* 22 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    /* WEBPACK VAR INJECTION */(function(__resourceQuery) {
    
    /* global __resourceQuery WorkerGlobalScope self */
    /* eslint prefer-destructuring: off */
    
    var url = __webpack_require__(23);
    var stripAnsi = __webpack_require__(30);
    var log = __webpack_require__(32).getLogger('webpack-dev-server');
    var socket = __webpack_require__(33);
    var overlay = __webpack_require__(35);
    
    function getCurrentScriptSource() {
      // `document.currentScript` is the most accurate way to find the current script,
      // but is not supported in all browsers.
      if (document.currentScript) {
        return document.currentScript.getAttribute('src');
      }
      // Fall back to getting all scripts in the document.
      var scriptElements = document.scripts || [];
      var currentScript = scriptElements[scriptElements.length - 1];
      if (currentScript) {
        return currentScript.getAttribute('src');
      }
      // Fail as there was no script to use.
      throw new Error('[WDS] Failed to get current script source.');
    }
    
    var urlParts = void 0;
    var hotReload = true;
    if (typeof window !== 'undefined') {
      var qs = window.location.search.toLowerCase();
      hotReload = qs.indexOf('hotreload=false') === -1;
    }
    if (true) {
      // If this bundle is inlined, use the resource query to get the correct url.
      urlParts = url.parse(__resourceQuery.substr(1));
    } else {
      // Else, get the url from the <script> this file was called with.
      var scriptHost = getCurrentScriptSource();
      // eslint-disable-next-line no-useless-escape
      scriptHost = scriptHost.replace(/\/[^\/]+$/, '');
      urlParts = url.parse(scriptHost || '/', false, true);
    }
    
    if (!urlParts.port || urlParts.port === '0') {
      urlParts.port = self.location.port;
    }
    
    var _hot = false;
    var initial = true;
    var currentHash = '';
    var useWarningOverlay = false;
    var useErrorOverlay = false;
    var useProgress = false;
    
    var INFO = 'info';
    var WARNING = 'warning';
    var ERROR = 'error';
    var NONE = 'none';
    
    // Set the default log level
    log.setDefaultLevel(INFO);
    
    // Send messages to the outside, so plugins can consume it.
    function sendMsg(type, data) {
      if (typeof self !== 'undefined' && (typeof WorkerGlobalScope === 'undefined' || !(self instanceof WorkerGlobalScope))) {
        self.postMessage({
          type: 'webpack' + type,
          data: data
        }, '*');
      }
    }
    
    var onSocketMsg = {
      hot: function hot() {
        _hot = true;
        log.info('[WDS] Hot Module Replacement enabled.');
      },
      invalid: function invalid() {
        log.info('[WDS] App updated. Recompiling...');
        // fixes #1042. overlay doesn't clear if errors are fixed but warnings remain.
        if (useWarningOverlay || useErrorOverlay) overlay.clear();
        sendMsg('Invalid');
      },
      hash: function hash(_hash) {
        currentHash = _hash;
      },
    
      'still-ok': function stillOk() {
        log.info('[WDS] Nothing changed.');
        if (useWarningOverlay || useErrorOverlay) overlay.clear();
        sendMsg('StillOk');
      },
      'log-level': function logLevel(level) {
        var hotCtx = __webpack_require__(40);
        if (hotCtx.keys().indexOf('./log') !== -1) {
          hotCtx('./log').setLogLevel(level);
        }
        switch (level) {
          case INFO:
          case ERROR:
            log.setLevel(level);
            break;
          case WARNING:
            // loglevel's warning name is different from webpack's
            log.setLevel('warn');
            break;
          case NONE:
            log.disableAll();
            break;
          default:
            log.error('[WDS] Unknown clientLogLevel \'' + level + '\'');
        }
      },
      overlay: function overlay(value) {
        if (typeof document !== 'undefined') {
          if (typeof value === 'boolean') {
            useWarningOverlay = false;
            useErrorOverlay = value;
          } else if (value) {
            useWarningOverlay = value.warnings;
            useErrorOverlay = value.errors;
          }
        }
      },
      progress: function progress(_progress) {
        if (typeof document !== 'undefined') {
          useProgress = _progress;
        }
      },
    
      'progress-update': function progressUpdate(data) {
        if (useProgress) log.info('[WDS] ' + data.percent + '% - ' + data.msg + '.');
      },
      ok: function ok() {
        sendMsg('Ok');
        if (useWarningOverlay || useErrorOverlay) overlay.clear();
        if (initial) return initial = false; // eslint-disable-line no-return-assign
        reloadApp();
      },
    
      'content-changed': function contentChanged() {
        log.info('[WDS] Content base changed. Reloading...');
        self.location.reload();
      },
      warnings: function warnings(_warnings) {
        log.warn('[WDS] Warnings while compiling.');
        var strippedWarnings = _warnings.map(function (warning) {
          return stripAnsi(warning);
        });
        sendMsg('Warnings', strippedWarnings);
        for (var i = 0; i < strippedWarnings.length; i++) {
          log.warn(strippedWarnings[i]);
        }
        if (useWarningOverlay) overlay.showMessage(_warnings);
    
        if (initial) return initial = false; // eslint-disable-line no-return-assign
        reloadApp();
      },
      errors: function errors(_errors) {
        log.error('[WDS] Errors while compiling. Reload prevented.');
        var strippedErrors = _errors.map(function (error) {
          return stripAnsi(error);
        });
        sendMsg('Errors', strippedErrors);
        for (var i = 0; i < strippedErrors.length; i++) {
          log.error(strippedErrors[i]);
        }
        if (useErrorOverlay) overlay.showMessage(_errors);
        initial = false;
      },
      error: function error(_error) {
        log.error(_error);
      },
      close: function close() {
        log.error('[WDS] Disconnected!');
        sendMsg('Close');
      }
    };
    
    var hostname = urlParts.hostname;
    var protocol = urlParts.protocol;
    
    // check ipv4 and ipv6 `all hostname`
    if (hostname === '0.0.0.0' || hostname === '::') {
      // why do we need this check?
      // hostname n/a for file protocol (example, when using electron, ionic)
      // see: https://github.com/webpack/webpack-dev-server/pull/384
      // eslint-disable-next-line no-bitwise
      if (self.location.hostname && !!~self.location.protocol.indexOf('http')) {
        hostname = self.location.hostname;
      }
    }
    
    // `hostname` can be empty when the script path is relative. In that case, specifying
    // a protocol would result in an invalid URL.
    // When https is used in the app, secure websockets are always necessary
    // because the browser doesn't accept non-secure websockets.
    if (hostname && (self.location.protocol === 'https:' || urlParts.hostname === '0.0.0.0')) {
      protocol = self.location.protocol;
    }
    
    var socketUrl = url.format({
      protocol: protocol,
      auth: urlParts.auth,
      hostname: hostname,
      port: urlParts.port,
      pathname: urlParts.path == null || urlParts.path === '/' ? '/sockjs-node' : urlParts.path
    });
    
    socket(socketUrl, onSocketMsg);
    
    var isUnloading = false;
    self.addEventListener('beforeunload', function () {
      isUnloading = true;
    });
    
    function reloadApp() {
      if (isUnloading || !hotReload) {
        return;
      }
      if (_hot) {
        log.info('[WDS] App hot update...');
        // eslint-disable-next-line global-require
        var hotEmitter = __webpack_require__(42);
        hotEmitter.emit('webpackHotUpdate', currentHash);
        if (typeof self !== 'undefined' && self.window) {
          // broadcast update to window
          self.postMessage('webpackHotUpdate' + currentHash, '*');
        }
      } else {
        var rootWindow = self;
        // use parent window for reload (in case we're in an iframe with no valid src)
        var intervalId = self.setInterval(function () {
          if (rootWindow.location.protocol !== 'about:') {
            // reload immediately if protocol is valid
            applyReload(rootWindow, intervalId);
          } else {
            rootWindow = rootWindow.parent;
            if (rootWindow.parent === rootWindow) {
              // if parent equals current window we've reached the root which would continue forever, so trigger a reload anyways
              applyReload(rootWindow, intervalId);
            }
          }
        });
      }
    
      function applyReload(rootWindow, intervalId) {
        clearInterval(intervalId);
        log.info('[WDS] App updated. Reloading...');
        rootWindow.location.reload();
      }
    }
    /* WEBPACK VAR INJECTION */}.call(exports, "?http://localhost:8080"))
    
    /***/ }),
    /* 23 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    // Copyright Joyent, Inc. and other Node contributors.
    //
    // Permission is hereby granted, free of charge, to any person obtaining a
    // copy of this software and associated documentation files (the
    // "Software"), to deal in the Software without restriction, including
    // without limitation the rights to use, copy, modify, merge, publish,
    // distribute, sublicense, and/or sell copies of the Software, and to permit
    // persons to whom the Software is furnished to do so, subject to the
    // following conditions:
    //
    // The above copyright notice and this permission notice shall be included
    // in all copies or substantial portions of the Software.
    //
    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
    // OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    // MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
    // NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
    // DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
    // OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
    // USE OR OTHER DEALINGS IN THE SOFTWARE.
    
    
    
    var punycode = __webpack_require__(24);
    var util = __webpack_require__(26);
    
    exports.parse = urlParse;
    exports.resolve = urlResolve;
    exports.resolveObject = urlResolveObject;
    exports.format = urlFormat;
    
    exports.Url = Url;
    
    function Url() {
      this.protocol = null;
      this.slashes = null;
      this.auth = null;
      this.host = null;
      this.port = null;
      this.hostname = null;
      this.hash = null;
      this.search = null;
      this.query = null;
      this.pathname = null;
      this.path = null;
      this.href = null;
    }
    
    // Reference: RFC 3986, RFC 1808, RFC 2396
    
    // define these here so at least they only have to be
    // compiled once on the first module load.
    var protocolPattern = /^([a-z0-9.+-]+:)/i,
        portPattern = /:[0-9]*$/,
    
        // Special case for a simple path URL
        simplePathPattern = /^(\/\/?(?!\/)[^\?\s]*)(\?[^\s]*)?$/,
    
        // RFC 2396: characters reserved for delimiting URLs.
        // We actually just auto-escape these.
        delims = ['<', '>', '"', '`', ' ', '\r', '\n', '\t'],
    
        // RFC 2396: characters not allowed for various reasons.
        unwise = ['{', '}', '|', '\\', '^', '`'].concat(delims),
    
        // Allowed by RFCs, but cause of XSS attacks.  Always escape these.
        autoEscape = ['\''].concat(unwise),
        // Characters that are never ever allowed in a hostname.
        // Note that any invalid chars are also handled, but these
        // are the ones that are *expected* to be seen, so we fast-path
        // them.
        nonHostChars = ['%', '/', '?', ';', '#'].concat(autoEscape),
        hostEndingChars = ['/', '?', '#'],
        hostnameMaxLen = 255,
        hostnamePartPattern = /^[+a-z0-9A-Z_-]{0,63}$/,
        hostnamePartStart = /^([+a-z0-9A-Z_-]{0,63})(.*)$/,
        // protocols that can allow "unsafe" and "unwise" chars.
        unsafeProtocol = {
          'javascript': true,
          'javascript:': true
        },
        // protocols that never have a hostname.
        hostlessProtocol = {
          'javascript': true,
          'javascript:': true
        },
        // protocols that always contain a // bit.
        slashedProtocol = {
          'http': true,
          'https': true,
          'ftp': true,
          'gopher': true,
          'file': true,
          'http:': true,
          'https:': true,
          'ftp:': true,
          'gopher:': true,
          'file:': true
        },
        querystring = __webpack_require__(27);
    
    function urlParse(url, parseQueryString, slashesDenoteHost) {
      if (url && util.isObject(url) && url instanceof Url) return url;
    
      var u = new Url;
      u.parse(url, parseQueryString, slashesDenoteHost);
      return u;
    }
    
    Url.prototype.parse = function(url, parseQueryString, slashesDenoteHost) {
      if (!util.isString(url)) {
        throw new TypeError("Parameter 'url' must be a string, not " + typeof url);
      }
    
      // Copy chrome, IE, opera backslash-handling behavior.
      // Back slashes before the query string get converted to forward slashes
      // See: https://code.google.com/p/chromium/issues/detail?id=25916
      var queryIndex = url.indexOf('?'),
          splitter =
              (queryIndex !== -1 && queryIndex < url.indexOf('#')) ? '?' : '#',
          uSplit = url.split(splitter),
          slashRegex = /\\/g;
      uSplit[0] = uSplit[0].replace(slashRegex, '/');
      url = uSplit.join(splitter);
    
      var rest = url;
    
      // trim before proceeding.
      // This is to support parse stuff like "  http://foo.com  \n"
      rest = rest.trim();
    
      if (!slashesDenoteHost && url.split('#').length === 1) {
        // Try fast path regexp
        var simplePath = simplePathPattern.exec(rest);
        if (simplePath) {
          this.path = rest;
          this.href = rest;
          this.pathname = simplePath[1];
          if (simplePath[2]) {
            this.search = simplePath[2];
            if (parseQueryString) {
              this.query = querystring.parse(this.search.substr(1));
            } else {
              this.query = this.search.substr(1);
            }
          } else if (parseQueryString) {
            this.search = '';
            this.query = {};
          }
          return this;
        }
      }
    
      var proto = protocolPattern.exec(rest);
      if (proto) {
        proto = proto[0];
        var lowerProto = proto.toLowerCase();
        this.protocol = lowerProto;
        rest = rest.substr(proto.length);
      }
    
      // figure out if it's got a host
      // user@server is *always* interpreted as a hostname, and url
      // resolution will treat //foo/bar as host=foo,path=bar because that's
      // how the browser resolves relative URLs.
      if (slashesDenoteHost || proto || rest.match(/^\/\/[^@\/]+@[^@\/]+/)) {
        var slashes = rest.substr(0, 2) === '//';
        if (slashes && !(proto && hostlessProtocol[proto])) {
          rest = rest.substr(2);
          this.slashes = true;
        }
      }
    
      if (!hostlessProtocol[proto] &&
          (slashes || (proto && !slashedProtocol[proto]))) {
    
        // there's a hostname.
        // the first instance of /, ?, ;, or # ends the host.
        //
        // If there is an @ in the hostname, then non-host chars *are* allowed
        // to the left of the last @ sign, unless some host-ending character
        // comes *before* the @-sign.
        // URLs are obnoxious.
        //
        // ex:
        // http://a@b@c/ => user:a@b host:c
        // http://a@b?@c => user:a host:c path:/?@c
    
        // v0.12 TODO(isaacs): This is not quite how Chrome does things.
        // Review our test case against browsers more comprehensively.
    
        // find the first instance of any hostEndingChars
        var hostEnd = -1;
        for (var i = 0; i < hostEndingChars.length; i++) {
          var hec = rest.indexOf(hostEndingChars[i]);
          if (hec !== -1 && (hostEnd === -1 || hec < hostEnd))
            hostEnd = hec;
        }
    
        // at this point, either we have an explicit point where the
        // auth portion cannot go past, or the last @ char is the decider.
        var auth, atSign;
        if (hostEnd === -1) {
          // atSign can be anywhere.
          atSign = rest.lastIndexOf('@');
        } else {
          // atSign must be in auth portion.
          // http://a@b/c@d => host:b auth:a path:/c@d
          atSign = rest.lastIndexOf('@', hostEnd);
        }
    
        // Now we have a portion which is definitely the auth.
        // Pull that off.
        if (atSign !== -1) {
          auth = rest.slice(0, atSign);
          rest = rest.slice(atSign + 1);
          this.auth = decodeURIComponent(auth);
        }
    
        // the host is the remaining to the left of the first non-host char
        hostEnd = -1;
        for (var i = 0; i < nonHostChars.length; i++) {
          var hec = rest.indexOf(nonHostChars[i]);
          if (hec !== -1 && (hostEnd === -1 || hec < hostEnd))
            hostEnd = hec;
        }
        // if we still have not hit it, then the entire thing is a host.
        if (hostEnd === -1)
          hostEnd = rest.length;
    
        this.host = rest.slice(0, hostEnd);
        rest = rest.slice(hostEnd);
    
        // pull out port.
        this.parseHost();
    
        // we've indicated that there is a hostname,
        // so even if it's empty, it has to be present.
        this.hostname = this.hostname || '';
    
        // if hostname begins with [ and ends with ]
        // assume that it's an IPv6 address.
        var ipv6Hostname = this.hostname[0] === '[' &&
            this.hostname[this.hostname.length - 1] === ']';
    
        // validate a little.
        if (!ipv6Hostname) {
          var hostparts = this.hostname.split(/\./);
          for (var i = 0, l = hostparts.length; i < l; i++) {
            var part = hostparts[i];
            if (!part) continue;
            if (!part.match(hostnamePartPattern)) {
              var newpart = '';
              for (var j = 0, k = part.length; j < k; j++) {
                if (part.charCodeAt(j) > 127) {
                  // we replace non-ASCII char with a temporary placeholder
                  // we need this to make sure size of hostname is not
                  // broken by replacing non-ASCII by nothing
                  newpart += 'x';
                } else {
                  newpart += part[j];
                }
              }
              // we test again with ASCII char only
              if (!newpart.match(hostnamePartPattern)) {
                var validParts = hostparts.slice(0, i);
                var notHost = hostparts.slice(i + 1);
                var bit = part.match(hostnamePartStart);
                if (bit) {
                  validParts.push(bit[1]);
                  notHost.unshift(bit[2]);
                }
                if (notHost.length) {
                  rest = '/' + notHost.join('.') + rest;
                }
                this.hostname = validParts.join('.');
                break;
              }
            }
          }
        }
    
        if (this.hostname.length > hostnameMaxLen) {
          this.hostname = '';
        } else {
          // hostnames are always lower case.
          this.hostname = this.hostname.toLowerCase();
        }
    
        if (!ipv6Hostname) {
          // IDNA Support: Returns a punycoded representation of "domain".
          // It only converts parts of the domain name that
          // have non-ASCII characters, i.e. it doesn't matter if
          // you call it with a domain that already is ASCII-only.
          this.hostname = punycode.toASCII(this.hostname);
        }
    
        var p = this.port ? ':' + this.port : '';
        var h = this.hostname || '';
        this.host = h + p;
        this.href += this.host;
    
        // strip [ and ] from the hostname
        // the host field still retains them, though
        if (ipv6Hostname) {
          this.hostname = this.hostname.substr(1, this.hostname.length - 2);
          if (rest[0] !== '/') {
            rest = '/' + rest;
          }
        }
      }
    
      // now rest is set to the post-host stuff.
      // chop off any delim chars.
      if (!unsafeProtocol[lowerProto]) {
    
        // First, make 100% sure that any "autoEscape" chars get
        // escaped, even if encodeURIComponent doesn't think they
        // need to be.
        for (var i = 0, l = autoEscape.length; i < l; i++) {
          var ae = autoEscape[i];
          if (rest.indexOf(ae) === -1)
            continue;
          var esc = encodeURIComponent(ae);
          if (esc === ae) {
            esc = escape(ae);
          }
          rest = rest.split(ae).join(esc);
        }
      }
    
    
      // chop off from the tail first.
      var hash = rest.indexOf('#');
      if (hash !== -1) {
        // got a fragment string.
        this.hash = rest.substr(hash);
        rest = rest.slice(0, hash);
      }
      var qm = rest.indexOf('?');
      if (qm !== -1) {
        this.search = rest.substr(qm);
        this.query = rest.substr(qm + 1);
        if (parseQueryString) {
          this.query = querystring.parse(this.query);
        }
        rest = rest.slice(0, qm);
      } else if (parseQueryString) {
        // no query string, but parseQueryString still requested
        this.search = '';
        this.query = {};
      }
      if (rest) this.pathname = rest;
      if (slashedProtocol[lowerProto] &&
          this.hostname && !this.pathname) {
        this.pathname = '/';
      }
    
      //to support http.request
      if (this.pathname || this.search) {
        var p = this.pathname || '';
        var s = this.search || '';
        this.path = p + s;
      }
    
      // finally, reconstruct the href based on what has been validated.
      this.href = this.format();
      return this;
    };
    
    // format a parsed object into a url string
    function urlFormat(obj) {
      // ensure it's an object, and not a string url.
      // If it's an obj, this is a no-op.
      // this way, you can call url_format() on strings
      // to clean up potentially wonky urls.
      if (util.isString(obj)) obj = urlParse(obj);
      if (!(obj instanceof Url)) return Url.prototype.format.call(obj);
      return obj.format();
    }
    
    Url.prototype.format = function() {
      var auth = this.auth || '';
      if (auth) {
        auth = encodeURIComponent(auth);
        auth = auth.replace(/%3A/i, ':');
        auth += '@';
      }
    
      var protocol = this.protocol || '',
          pathname = this.pathname || '',
          hash = this.hash || '',
          host = false,
          query = '';
    
      if (this.host) {
        host = auth + this.host;
      } else if (this.hostname) {
        host = auth + (this.hostname.indexOf(':') === -1 ?
            this.hostname :
            '[' + this.hostname + ']');
        if (this.port) {
          host += ':' + this.port;
        }
      }
    
      if (this.query &&
          util.isObject(this.query) &&
          Object.keys(this.query).length) {
        query = querystring.stringify(this.query);
      }
    
      var search = this.search || (query && ('?' + query)) || '';
    
      if (protocol && protocol.substr(-1) !== ':') protocol += ':';
    
      // only the slashedProtocols get the //.  Not mailto:, xmpp:, etc.
      // unless they had them to begin with.
      if (this.slashes ||
          (!protocol || slashedProtocol[protocol]) && host !== false) {
        host = '//' + (host || '');
        if (pathname && pathname.charAt(0) !== '/') pathname = '/' + pathname;
      } else if (!host) {
        host = '';
      }
    
      if (hash && hash.charAt(0) !== '#') hash = '#' + hash;
      if (search && search.charAt(0) !== '?') search = '?' + search;
    
      pathname = pathname.replace(/[?#]/g, function(match) {
        return encodeURIComponent(match);
      });
      search = search.replace('#', '%23');
    
      return protocol + host + pathname + search + hash;
    };
    
    function urlResolve(source, relative) {
      return urlParse(source, false, true).resolve(relative);
    }
    
    Url.prototype.resolve = function(relative) {
      return this.resolveObject(urlParse(relative, false, true)).format();
    };
    
    function urlResolveObject(source, relative) {
      if (!source) return relative;
      return urlParse(source, false, true).resolveObject(relative);
    }
    
    Url.prototype.resolveObject = function(relative) {
      if (util.isString(relative)) {
        var rel = new Url();
        rel.parse(relative, false, true);
        relative = rel;
      }
    
      var result = new Url();
      var tkeys = Object.keys(this);
      for (var tk = 0; tk < tkeys.length; tk++) {
        var tkey = tkeys[tk];
        result[tkey] = this[tkey];
      }
    
      // hash is always overridden, no matter what.
      // even href="" will remove it.
      result.hash = relative.hash;
    
      // if the relative url is empty, then there's nothing left to do here.
      if (relative.href === '') {
        result.href = result.format();
        return result;
      }
    
      // hrefs like //foo/bar always cut to the protocol.
      if (relative.slashes && !relative.protocol) {
        // take everything except the protocol from relative
        var rkeys = Object.keys(relative);
        for (var rk = 0; rk < rkeys.length; rk++) {
          var rkey = rkeys[rk];
          if (rkey !== 'protocol')
            result[rkey] = relative[rkey];
        }
    
        //urlParse appends trailing / to urls like http://www.example.com
        if (slashedProtocol[result.protocol] &&
            result.hostname && !result.pathname) {
          result.path = result.pathname = '/';
        }
    
        result.href = result.format();
        return result;
      }
    
      if (relative.protocol && relative.protocol !== result.protocol) {
        // if it's a known url protocol, then changing
        // the protocol does weird things
        // first, if it's not file:, then we MUST have a host,
        // and if there was a path
        // to begin with, then we MUST have a path.
        // if it is file:, then the host is dropped,
        // because that's known to be hostless.
        // anything else is assumed to be absolute.
        if (!slashedProtocol[relative.protocol]) {
          var keys = Object.keys(relative);
          for (var v = 0; v < keys.length; v++) {
            var k = keys[v];
            result[k] = relative[k];
          }
          result.href = result.format();
          return result;
        }
    
        result.protocol = relative.protocol;
        if (!relative.host && !hostlessProtocol[relative.protocol]) {
          var relPath = (relative.pathname || '').split('/');
          while (relPath.length && !(relative.host = relPath.shift()));
          if (!relative.host) relative.host = '';
          if (!relative.hostname) relative.hostname = '';
          if (relPath[0] !== '') relPath.unshift('');
          if (relPath.length < 2) relPath.unshift('');
          result.pathname = relPath.join('/');
        } else {
          result.pathname = relative.pathname;
        }
        result.search = relative.search;
        result.query = relative.query;
        result.host = relative.host || '';
        result.auth = relative.auth;
        result.hostname = relative.hostname || relative.host;
        result.port = relative.port;
        // to support http.request
        if (result.pathname || result.search) {
          var p = result.pathname || '';
          var s = result.search || '';
          result.path = p + s;
        }
        result.slashes = result.slashes || relative.slashes;
        result.href = result.format();
        return result;
      }
    
      var isSourceAbs = (result.pathname && result.pathname.charAt(0) === '/'),
          isRelAbs = (
              relative.host ||
              relative.pathname && relative.pathname.charAt(0) === '/'
          ),
          mustEndAbs = (isRelAbs || isSourceAbs ||
                        (result.host && relative.pathname)),
          removeAllDots = mustEndAbs,
          srcPath = result.pathname && result.pathname.split('/') || [],
          relPath = relative.pathname && relative.pathname.split('/') || [],
          psychotic = result.protocol && !slashedProtocol[result.protocol];
    
      // if the url is a non-slashed url, then relative
      // links like ../.. should be able
      // to crawl up to the hostname, as well.  This is strange.
      // result.protocol has already been set by now.
      // Later on, put the first path part into the host field.
      if (psychotic) {
        result.hostname = '';
        result.port = null;
        if (result.host) {
          if (srcPath[0] === '') srcPath[0] = result.host;
          else srcPath.unshift(result.host);
        }
        result.host = '';
        if (relative.protocol) {
          relative.hostname = null;
          relative.port = null;
          if (relative.host) {
            if (relPath[0] === '') relPath[0] = relative.host;
            else relPath.unshift(relative.host);
          }
          relative.host = null;
        }
        mustEndAbs = mustEndAbs && (relPath[0] === '' || srcPath[0] === '');
      }
    
      if (isRelAbs) {
        // it's absolute.
        result.host = (relative.host || relative.host === '') ?
                      relative.host : result.host;
        result.hostname = (relative.hostname || relative.hostname === '') ?
                          relative.hostname : result.hostname;
        result.search = relative.search;
        result.query = relative.query;
        srcPath = relPath;
        // fall through to the dot-handling below.
      } else if (relPath.length) {
        // it's relative
        // throw away the existing file, and take the new path instead.
        if (!srcPath) srcPath = [];
        srcPath.pop();
        srcPath = srcPath.concat(relPath);
        result.search = relative.search;
        result.query = relative.query;
      } else if (!util.isNullOrUndefined(relative.search)) {
        // just pull out the search.
        // like href='?foo'.
        // Put this after the other two cases because it simplifies the booleans
        if (psychotic) {
          result.hostname = result.host = srcPath.shift();
          //occationaly the auth can get stuck only in host
          //this especially happens in cases like
          //url.resolveObject('mailto:local1@domain1', 'local2@domain2')
          var authInHost = result.host && result.host.indexOf('@') > 0 ?
                           result.host.split('@') : false;
          if (authInHost) {
            result.auth = authInHost.shift();
            result.host = result.hostname = authInHost.shift();
          }
        }
        result.search = relative.search;
        result.query = relative.query;
        //to support http.request
        if (!util.isNull(result.pathname) || !util.isNull(result.search)) {
          result.path = (result.pathname ? result.pathname : '') +
                        (result.search ? result.search : '');
        }
        result.href = result.format();
        return result;
      }
    
      if (!srcPath.length) {
        // no path at all.  easy.
        // we've already handled the other stuff above.
        result.pathname = null;
        //to support http.request
        if (result.search) {
          result.path = '/' + result.search;
        } else {
          result.path = null;
        }
        result.href = result.format();
        return result;
      }
    
      // if a url ENDs in . or .., then it must get a trailing slash.
      // however, if it ends in anything else non-slashy,
      // then it must NOT get a trailing slash.
      var last = srcPath.slice(-1)[0];
      var hasTrailingSlash = (
          (result.host || relative.host || srcPath.length > 1) &&
          (last === '.' || last === '..') || last === '');
    
      // strip single dots, resolve double dots to parent dir
      // if the path tries to go above the root, `up` ends up > 0
      var up = 0;
      for (var i = srcPath.length; i >= 0; i--) {
        last = srcPath[i];
        if (last === '.') {
          srcPath.splice(i, 1);
        } else if (last === '..') {
          srcPath.splice(i, 1);
          up++;
        } else if (up) {
          srcPath.splice(i, 1);
          up--;
        }
      }
    
      // if the path is allowed to go above the root, restore leading ..s
      if (!mustEndAbs && !removeAllDots) {
        for (; up--; up) {
          srcPath.unshift('..');
        }
      }
    
      if (mustEndAbs && srcPath[0] !== '' &&
          (!srcPath[0] || srcPath[0].charAt(0) !== '/')) {
        srcPath.unshift('');
      }
    
      if (hasTrailingSlash && (srcPath.join('/').substr(-1) !== '/')) {
        srcPath.push('');
      }
    
      var isAbsolute = srcPath[0] === '' ||
          (srcPath[0] && srcPath[0].charAt(0) === '/');
    
      // put the host back
      if (psychotic) {
        result.hostname = result.host = isAbsolute ? '' :
                                        srcPath.length ? srcPath.shift() : '';
        //occationaly the auth can get stuck only in host
        //this especially happens in cases like
        //url.resolveObject('mailto:local1@domain1', 'local2@domain2')
        var authInHost = result.host && result.host.indexOf('@') > 0 ?
                         result.host.split('@') : false;
        if (authInHost) {
          result.auth = authInHost.shift();
          result.host = result.hostname = authInHost.shift();
        }
      }
    
      mustEndAbs = mustEndAbs || (result.host && srcPath.length);
    
      if (mustEndAbs && !isAbsolute) {
        srcPath.unshift('');
      }
    
      if (!srcPath.length) {
        result.pathname = null;
        result.path = null;
      } else {
        result.pathname = srcPath.join('/');
      }
    
      //to support request.http
      if (!util.isNull(result.pathname) || !util.isNull(result.search)) {
        result.path = (result.pathname ? result.pathname : '') +
                      (result.search ? result.search : '');
      }
      result.auth = relative.auth || result.auth;
      result.slashes = result.slashes || relative.slashes;
      result.href = result.format();
      return result;
    };
    
    Url.prototype.parseHost = function() {
      var host = this.host;
      var port = portPattern.exec(host);
      if (port) {
        port = port[0];
        if (port !== ':') {
          this.port = port.substr(1);
        }
        host = host.substr(0, host.length - port.length);
      }
      if (host) this.hostname = host;
    };
    
    
    /***/ }),
    /* 24 */
    /***/ (function(module, exports, __webpack_require__) {
    
    /* WEBPACK VAR INJECTION */(function(module, global) {var __WEBPACK_AMD_DEFINE_RESULT__;/*! https://mths.be/punycode v1.4.1 by @mathias */
    ;(function(root) {
    
        /** Detect free variables */
        var freeExports = typeof exports == 'object' && exports &&
            !exports.nodeType && exports;
        var freeModule = typeof module == 'object' && module &&
            !module.nodeType && module;
        var freeGlobal = typeof global == 'object' && global;
        if (
            freeGlobal.global === freeGlobal ||
            freeGlobal.window === freeGlobal ||
            freeGlobal.self === freeGlobal
        ) {
            root = freeGlobal;
        }
    
        /**
         * The `punycode` object.
         * @name punycode
         * @type Object
         */
        var punycode,
    
        /** Highest positive signed 32-bit float value */
        maxInt = 2147483647, // aka. 0x7FFFFFFF or 2^31-1
    
        /** Bootstring parameters */
        base = 36,
        tMin = 1,
        tMax = 26,
        skew = 38,
        damp = 700,
        initialBias = 72,
        initialN = 128, // 0x80
        delimiter = '-', // '\x2D'
    
        /** Regular expressions */
        regexPunycode = /^xn--/,
        regexNonASCII = /[^\x20-\x7E]/, // unprintable ASCII chars + non-ASCII chars
        regexSeparators = /[\x2E\u3002\uFF0E\uFF61]/g, // RFC 3490 separators
    
        /** Error messages */
        errors = {
            'overflow': 'Overflow: input needs wider integers to process',
            'not-basic': 'Illegal input >= 0x80 (not a basic code point)',
            'invalid-input': 'Invalid input'
        },
    
        /** Convenience shortcuts */
        baseMinusTMin = base - tMin,
        floor = Math.floor,
        stringFromCharCode = String.fromCharCode,
    
        /** Temporary variable */
        key;
    
        /*--------------------------------------------------------------------------*/
    
        /**
         * A generic error utility function.
         * @private
         * @param {String} type The error type.
         * @returns {Error} Throws a `RangeError` with the applicable error message.
         */
        function error(type) {
            throw new RangeError(errors[type]);
        }
    
        /**
         * A generic `Array#map` utility function.
         * @private
         * @param {Array} array The array to iterate over.
         * @param {Function} callback The function that gets called for every array
         * item.
         * @returns {Array} A new array of values returned by the callback function.
         */
        function map(array, fn) {
            var length = array.length;
            var result = [];
            while (length--) {
                result[length] = fn(array[length]);
            }
            return result;
        }
    
        /**
         * A simple `Array#map`-like wrapper to work with domain name strings or email
         * addresses.
         * @private
         * @param {String} domain The domain name or email address.
         * @param {Function} callback The function that gets called for every
         * character.
         * @returns {Array} A new string of characters returned by the callback
         * function.
         */
        function mapDomain(string, fn) {
            var parts = string.split('@');
            var result = '';
            if (parts.length > 1) {
                // In email addresses, only the domain name should be punycoded. Leave
                // the local part (i.e. everything up to `@`) intact.
                result = parts[0] + '@';
                string = parts[1];
            }
            // Avoid `split(regex)` for IE8 compatibility. See #17.
            string = string.replace(regexSeparators, '\x2E');
            var labels = string.split('.');
            var encoded = map(labels, fn).join('.');
            return result + encoded;
        }
    
        /**
         * Creates an array containing the numeric code points of each Unicode
         * character in the string. While JavaScript uses UCS-2 internally,
         * this function will convert a pair of surrogate halves (each of which
         * UCS-2 exposes as separate characters) into a single code point,
         * matching UTF-16.
         * @see `punycode.ucs2.encode`
         * @see <https://mathiasbynens.be/notes/javascript-encoding>
         * @memberOf punycode.ucs2
         * @name decode
         * @param {String} string The Unicode input string (UCS-2).
         * @returns {Array} The new array of code points.
         */
        function ucs2decode(string) {
            var output = [],
                counter = 0,
                length = string.length,
                value,
                extra;
            while (counter < length) {
                value = string.charCodeAt(counter++);
                if (value >= 0xD800 && value <= 0xDBFF && counter < length) {
                    // high surrogate, and there is a next character
                    extra = string.charCodeAt(counter++);
                    if ((extra & 0xFC00) == 0xDC00) { // low surrogate
                        output.push(((value & 0x3FF) << 10) + (extra & 0x3FF) + 0x10000);
                    } else {
                        // unmatched surrogate; only append this code unit, in case the next
                        // code unit is the high surrogate of a surrogate pair
                        output.push(value);
                        counter--;
                    }
                } else {
                    output.push(value);
                }
            }
            return output;
        }
    
        /**
         * Creates a string based on an array of numeric code points.
         * @see `punycode.ucs2.decode`
         * @memberOf punycode.ucs2
         * @name encode
         * @param {Array} codePoints The array of numeric code points.
         * @returns {String} The new Unicode string (UCS-2).
         */
        function ucs2encode(array) {
            return map(array, function(value) {
                var output = '';
                if (value > 0xFFFF) {
                    value -= 0x10000;
                    output += stringFromCharCode(value >>> 10 & 0x3FF | 0xD800);
                    value = 0xDC00 | value & 0x3FF;
                }
                output += stringFromCharCode(value);
                return output;
            }).join('');
        }
    
        /**
         * Converts a basic code point into a digit/integer.
         * @see `digitToBasic()`
         * @private
         * @param {Number} codePoint The basic numeric code point value.
         * @returns {Number} The numeric value of a basic code point (for use in
         * representing integers) in the range `0` to `base - 1`, or `base` if
         * the code point does not represent a value.
         */
        function basicToDigit(codePoint) {
            if (codePoint - 48 < 10) {
                return codePoint - 22;
            }
            if (codePoint - 65 < 26) {
                return codePoint - 65;
            }
            if (codePoint - 97 < 26) {
                return codePoint - 97;
            }
            return base;
        }
    
        /**
         * Converts a digit/integer into a basic code point.
         * @see `basicToDigit()`
         * @private
         * @param {Number} digit The numeric value of a basic code point.
         * @returns {Number} The basic code point whose value (when used for
         * representing integers) is `digit`, which needs to be in the range
         * `0` to `base - 1`. If `flag` is non-zero, the uppercase form is
         * used; else, the lowercase form is used. The behavior is undefined
         * if `flag` is non-zero and `digit` has no uppercase form.
         */
        function digitToBasic(digit, flag) {
            //  0..25 map to ASCII a..z or A..Z
            // 26..35 map to ASCII 0..9
            return digit + 22 + 75 * (digit < 26) - ((flag != 0) << 5);
        }
    
        /**
         * Bias adaptation function as per section 3.4 of RFC 3492.
         * https://tools.ietf.org/html/rfc3492#section-3.4
         * @private
         */
        function adapt(delta, numPoints, firstTime) {
            var k = 0;
            delta = firstTime ? floor(delta / damp) : delta >> 1;
            delta += floor(delta / numPoints);
            for (/* no initialization */; delta > baseMinusTMin * tMax >> 1; k += base) {
                delta = floor(delta / baseMinusTMin);
            }
            return floor(k + (baseMinusTMin + 1) * delta / (delta + skew));
        }
    
        /**
         * Converts a Punycode string of ASCII-only symbols to a string of Unicode
         * symbols.
         * @memberOf punycode
         * @param {String} input The Punycode string of ASCII-only symbols.
         * @returns {String} The resulting string of Unicode symbols.
         */
        function decode(input) {
            // Don't use UCS-2
            var output = [],
                inputLength = input.length,
                out,
                i = 0,
                n = initialN,
                bias = initialBias,
                basic,
                j,
                index,
                oldi,
                w,
                k,
                digit,
                t,
                /** Cached calculation results */
                baseMinusT;
    
            // Handle the basic code points: let `basic` be the number of input code
            // points before the last delimiter, or `0` if there is none, then copy
            // the first basic code points to the output.
    
            basic = input.lastIndexOf(delimiter);
            if (basic < 0) {
                basic = 0;
            }
    
            for (j = 0; j < basic; ++j) {
                // if it's not a basic code point
                if (input.charCodeAt(j) >= 0x80) {
                    error('not-basic');
                }
                output.push(input.charCodeAt(j));
            }
    
            // Main decoding loop: start just after the last delimiter if any basic code
            // points were copied; start at the beginning otherwise.
    
            for (index = basic > 0 ? basic + 1 : 0; index < inputLength; /* no final expression */) {
    
                // `index` is the index of the next character to be consumed.
                // Decode a generalized variable-length integer into `delta`,
                // which gets added to `i`. The overflow checking is easier
                // if we increase `i` as we go, then subtract off its starting
                // value at the end to obtain `delta`.
                for (oldi = i, w = 1, k = base; /* no condition */; k += base) {
    
                    if (index >= inputLength) {
                        error('invalid-input');
                    }
    
                    digit = basicToDigit(input.charCodeAt(index++));
    
                    if (digit >= base || digit > floor((maxInt - i) / w)) {
                        error('overflow');
                    }
    
                    i += digit * w;
                    t = k <= bias ? tMin : (k >= bias + tMax ? tMax : k - bias);
    
                    if (digit < t) {
                        break;
                    }
    
                    baseMinusT = base - t;
                    if (w > floor(maxInt / baseMinusT)) {
                        error('overflow');
                    }
    
                    w *= baseMinusT;
    
                }
    
                out = output.length + 1;
                bias = adapt(i - oldi, out, oldi == 0);
    
                // `i` was supposed to wrap around from `out` to `0`,
                // incrementing `n` each time, so we'll fix that now:
                if (floor(i / out) > maxInt - n) {
                    error('overflow');
                }
    
                n += floor(i / out);
                i %= out;
    
                // Insert `n` at position `i` of the output
                output.splice(i++, 0, n);
    
            }
    
            return ucs2encode(output);
        }
    
        /**
         * Converts a string of Unicode symbols (e.g. a domain name label) to a
         * Punycode string of ASCII-only symbols.
         * @memberOf punycode
         * @param {String} input The string of Unicode symbols.
         * @returns {String} The resulting Punycode string of ASCII-only symbols.
         */
        function encode(input) {
            var n,
                delta,
                handledCPCount,
                basicLength,
                bias,
                j,
                m,
                q,
                k,
                t,
                currentValue,
                output = [],
                /** `inputLength` will hold the number of code points in `input`. */
                inputLength,
                /** Cached calculation results */
                handledCPCountPlusOne,
                baseMinusT,
                qMinusT;
    
            // Convert the input in UCS-2 to Unicode
            input = ucs2decode(input);
    
            // Cache the length
            inputLength = input.length;
    
            // Initialize the state
            n = initialN;
            delta = 0;
            bias = initialBias;
    
            // Handle the basic code points
            for (j = 0; j < inputLength; ++j) {
                currentValue = input[j];
                if (currentValue < 0x80) {
                    output.push(stringFromCharCode(currentValue));
                }
            }
    
            handledCPCount = basicLength = output.length;
    
            // `handledCPCount` is the number of code points that have been handled;
            // `basicLength` is the number of basic code points.
    
            // Finish the basic string - if it is not empty - with a delimiter
            if (basicLength) {
                output.push(delimiter);
            }
    
            // Main encoding loop:
            while (handledCPCount < inputLength) {
    
                // All non-basic code points < n have been handled already. Find the next
                // larger one:
                for (m = maxInt, j = 0; j < inputLength; ++j) {
                    currentValue = input[j];
                    if (currentValue >= n && currentValue < m) {
                        m = currentValue;
                    }
                }
    
                // Increase `delta` enough to advance the decoder's <n,i> state to <m,0>,
                // but guard against overflow
                handledCPCountPlusOne = handledCPCount + 1;
                if (m - n > floor((maxInt - delta) / handledCPCountPlusOne)) {
                    error('overflow');
                }
    
                delta += (m - n) * handledCPCountPlusOne;
                n = m;
    
                for (j = 0; j < inputLength; ++j) {
                    currentValue = input[j];
    
                    if (currentValue < n && ++delta > maxInt) {
                        error('overflow');
                    }
    
                    if (currentValue == n) {
                        // Represent delta as a generalized variable-length integer
                        for (q = delta, k = base; /* no condition */; k += base) {
                            t = k <= bias ? tMin : (k >= bias + tMax ? tMax : k - bias);
                            if (q < t) {
                                break;
                            }
                            qMinusT = q - t;
                            baseMinusT = base - t;
                            output.push(
                                stringFromCharCode(digitToBasic(t + qMinusT % baseMinusT, 0))
                            );
                            q = floor(qMinusT / baseMinusT);
                        }
    
                        output.push(stringFromCharCode(digitToBasic(q, 0)));
                        bias = adapt(delta, handledCPCountPlusOne, handledCPCount == basicLength);
                        delta = 0;
                        ++handledCPCount;
                    }
                }
    
                ++delta;
                ++n;
    
            }
            return output.join('');
        }
    
        /**
         * Converts a Punycode string representing a domain name or an email address
         * to Unicode. Only the Punycoded parts of the input will be converted, i.e.
         * it doesn't matter if you call it on a string that has already been
         * converted to Unicode.
         * @memberOf punycode
         * @param {String} input The Punycoded domain name or email address to
         * convert to Unicode.
         * @returns {String} The Unicode representation of the given Punycode
         * string.
         */
        function toUnicode(input) {
            return mapDomain(input, function(string) {
                return regexPunycode.test(string)
                    ? decode(string.slice(4).toLowerCase())
                    : string;
            });
        }
    
        /**
         * Converts a Unicode string representing a domain name or an email address to
         * Punycode. Only the non-ASCII parts of the domain name will be converted,
         * i.e. it doesn't matter if you call it with a domain that's already in
         * ASCII.
         * @memberOf punycode
         * @param {String} input The domain name or email address to convert, as a
         * Unicode string.
         * @returns {String} The Punycode representation of the given domain name or
         * email address.
         */
        function toASCII(input) {
            return mapDomain(input, function(string) {
                return regexNonASCII.test(string)
                    ? 'xn--' + encode(string)
                    : string;
            });
        }
    
        /*--------------------------------------------------------------------------*/
    
        /** Define the public API */
        punycode = {
            /**
             * A string representing the current Punycode.js version number.
             * @memberOf punycode
             * @type String
             */
            'version': '1.4.1',
            /**
             * An object of methods to convert from JavaScript's internal character
             * representation (UCS-2) to Unicode code points, and back.
             * @see <https://mathiasbynens.be/notes/javascript-encoding>
             * @memberOf punycode
             * @type Object
             */
            'ucs2': {
                'decode': ucs2decode,
                'encode': ucs2encode
            },
            'decode': decode,
            'encode': encode,
            'toASCII': toASCII,
            'toUnicode': toUnicode
        };
    
        /** Expose `punycode` */
        // Some AMD build optimizers, like r.js, check for specific condition patterns
        // like the following:
        if (
            true
        ) {
            !(__WEBPACK_AMD_DEFINE_RESULT__ = (function() {
                return punycode;
            }).call(exports, __webpack_require__, exports, module),
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
        } else if (freeExports && freeModule) {
            if (module.exports == freeExports) {
                // in Node.js, io.js, or RingoJS v0.8.0+
                freeModule.exports = punycode;
            } else {
                // in Narwhal or RingoJS v0.7.0-
                for (key in punycode) {
                    punycode.hasOwnProperty(key) && (freeExports[key] = punycode[key]);
                }
            }
        } else {
            // in Rhino or a web browser
            root.punycode = punycode;
        }
    
    }(this));
    
    /* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(25)(module), __webpack_require__(7)))
    
    /***/ }),
    /* 25 */
    /***/ (function(module, exports) {
    
    module.exports = function(module) {
        if(!module.webpackPolyfill) {
            module.deprecate = function() {};
            module.paths = [];
            // module.parent = undefined by default
            if(!module.children) module.children = [];
            Object.defineProperty(module, "loaded", {
                enumerable: true,
                get: function() {
                    return module.l;
                }
            });
            Object.defineProperty(module, "id", {
                enumerable: true,
                get: function() {
                    return module.i;
                }
            });
            module.webpackPolyfill = 1;
        }
        return module;
    };
    
    
    /***/ }),
    /* 26 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    
    module.exports = {
      isString: function(arg) {
        return typeof(arg) === 'string';
      },
      isObject: function(arg) {
        return typeof(arg) === 'object' && arg !== null;
      },
      isNull: function(arg) {
        return arg === null;
      },
      isNullOrUndefined: function(arg) {
        return arg == null;
      }
    };
    
    
    /***/ }),
    /* 27 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    
    exports.decode = exports.parse = __webpack_require__(28);
    exports.encode = exports.stringify = __webpack_require__(29);
    
    
    /***/ }),
    /* 28 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    // Copyright Joyent, Inc. and other Node contributors.
    //
    // Permission is hereby granted, free of charge, to any person obtaining a
    // copy of this software and associated documentation files (the
    // "Software"), to deal in the Software without restriction, including
    // without limitation the rights to use, copy, modify, merge, publish,
    // distribute, sublicense, and/or sell copies of the Software, and to permit
    // persons to whom the Software is furnished to do so, subject to the
    // following conditions:
    //
    // The above copyright notice and this permission notice shall be included
    // in all copies or substantial portions of the Software.
    //
    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
    // OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    // MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
    // NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
    // DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
    // OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
    // USE OR OTHER DEALINGS IN THE SOFTWARE.
    
    
    
    // If obj.hasOwnProperty has been overridden, then calling
    // obj.hasOwnProperty(prop) will break.
    // See: https://github.com/joyent/node/issues/1707
    function hasOwnProperty(obj, prop) {
      return Object.prototype.hasOwnProperty.call(obj, prop);
    }
    
    module.exports = function(qs, sep, eq, options) {
      sep = sep || '&';
      eq = eq || '=';
      var obj = {};
    
      if (typeof qs !== 'string' || qs.length === 0) {
        return obj;
      }
    
      var regexp = /\+/g;
      qs = qs.split(sep);
    
      var maxKeys = 1000;
      if (options && typeof options.maxKeys === 'number') {
        maxKeys = options.maxKeys;
      }
    
      var len = qs.length;
      // maxKeys <= 0 means that we should not limit keys count
      if (maxKeys > 0 && len > maxKeys) {
        len = maxKeys;
      }
    
      for (var i = 0; i < len; ++i) {
        var x = qs[i].replace(regexp, '%20'),
            idx = x.indexOf(eq),
            kstr, vstr, k, v;
    
        if (idx >= 0) {
          kstr = x.substr(0, idx);
          vstr = x.substr(idx + 1);
        } else {
          kstr = x;
          vstr = '';
        }
    
        k = decodeURIComponent(kstr);
        v = decodeURIComponent(vstr);
    
        if (!hasOwnProperty(obj, k)) {
          obj[k] = v;
        } else if (isArray(obj[k])) {
          obj[k].push(v);
        } else {
          obj[k] = [obj[k], v];
        }
      }
    
      return obj;
    };
    
    var isArray = Array.isArray || function (xs) {
      return Object.prototype.toString.call(xs) === '[object Array]';
    };
    
    
    /***/ }),
    /* 29 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    // Copyright Joyent, Inc. and other Node contributors.
    //
    // Permission is hereby granted, free of charge, to any person obtaining a
    // copy of this software and associated documentation files (the
    // "Software"), to deal in the Software without restriction, including
    // without limitation the rights to use, copy, modify, merge, publish,
    // distribute, sublicense, and/or sell copies of the Software, and to permit
    // persons to whom the Software is furnished to do so, subject to the
    // following conditions:
    //
    // The above copyright notice and this permission notice shall be included
    // in all copies or substantial portions of the Software.
    //
    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
    // OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    // MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
    // NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
    // DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
    // OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
    // USE OR OTHER DEALINGS IN THE SOFTWARE.
    
    
    
    var stringifyPrimitive = function(v) {
      switch (typeof v) {
        case 'string':
          return v;
    
        case 'boolean':
          return v ? 'true' : 'false';
    
        case 'number':
          return isFinite(v) ? v : '';
    
        default:
          return '';
      }
    };
    
    module.exports = function(obj, sep, eq, name) {
      sep = sep || '&';
      eq = eq || '=';
      if (obj === null) {
        obj = undefined;
      }
    
      if (typeof obj === 'object') {
        return map(objectKeys(obj), function(k) {
          var ks = encodeURIComponent(stringifyPrimitive(k)) + eq;
          if (isArray(obj[k])) {
            return map(obj[k], function(v) {
              return ks + encodeURIComponent(stringifyPrimitive(v));
            }).join(sep);
          } else {
            return ks + encodeURIComponent(stringifyPrimitive(obj[k]));
          }
        }).join(sep);
    
      }
    
      if (!name) return '';
      return encodeURIComponent(stringifyPrimitive(name)) + eq +
             encodeURIComponent(stringifyPrimitive(obj));
    };
    
    var isArray = Array.isArray || function (xs) {
      return Object.prototype.toString.call(xs) === '[object Array]';
    };
    
    function map (xs, f) {
      if (xs.map) return xs.map(f);
      var res = [];
      for (var i = 0; i < xs.length; i++) {
        res.push(f(xs[i], i));
      }
      return res;
    }
    
    var objectKeys = Object.keys || function (obj) {
      var res = [];
      for (var key in obj) {
        if (Object.prototype.hasOwnProperty.call(obj, key)) res.push(key);
      }
      return res;
    };
    
    
    /***/ }),
    /* 30 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    var ansiRegex = __webpack_require__(31)();
    
    module.exports = function (str) {
        return typeof str === 'string' ? str.replace(ansiRegex, '') : str;
    };
    
    
    /***/ }),
    /* 31 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    module.exports = function () {
        return /[\u001b\u009b][[()#;?]*(?:[0-9]{1,4}(?:;[0-9]{0,4})*)?[0-9A-PRZcf-nqry=><]/g;
    };
    
    
    /***/ }),
    /* 32 */
    /***/ (function(module, exports, __webpack_require__) {
    
    var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/*
    * loglevel - https://github.com/pimterry/loglevel
    *
    * Copyright (c) 2013 Tim Perry
    * Licensed under the MIT license.
    */
    (function (root, definition) {
        "use strict";
        if (true) {
            !(__WEBPACK_AMD_DEFINE_FACTORY__ = (definition),
                    __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
                    (__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
                    __WEBPACK_AMD_DEFINE_FACTORY__),
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
        } else if (typeof module === 'object' && module.exports) {
            module.exports = definition();
        } else {
            root.log = definition();
        }
    }(this, function () {
        "use strict";
    
        // Slightly dubious tricks to cut down minimized file size
        var noop = function() {};
        var undefinedType = "undefined";
        var isIE = (typeof window !== undefinedType) && (
            /Trident\/|MSIE /.test(window.navigator.userAgent)
        );
    
        var logMethods = [
            "trace",
            "debug",
            "info",
            "warn",
            "error"
        ];
    
        // Cross-browser bind equivalent that works at least back to IE6
        function bindMethod(obj, methodName) {
            var method = obj[methodName];
            if (typeof method.bind === 'function') {
                return method.bind(obj);
            } else {
                try {
                    return Function.prototype.bind.call(method, obj);
                } catch (e) {
                    // Missing bind shim or IE8 + Modernizr, fallback to wrapping
                    return function() {
                        return Function.prototype.apply.apply(method, [obj, arguments]);
                    };
                }
            }
        }
    
        // Trace() doesn't print the message in IE, so for that case we need to wrap it
        function traceForIE() {
            if (console.log) {
                if (console.log.apply) {
                    console.log.apply(console, arguments);
                } else {
                    // In old IE, native console methods themselves don't have apply().
                    Function.prototype.apply.apply(console.log, [console, arguments]);
                }
            }
            if (console.trace) console.trace();
        }
    
        // Build the best logging method possible for this env
        // Wherever possible we want to bind, not wrap, to preserve stack traces
        function realMethod(methodName) {
            if (methodName === 'debug') {
                methodName = 'log';
            }
    
            if (typeof console === undefinedType) {
                return false; // No method possible, for now - fixed later by enableLoggingWhenConsoleArrives
            } else if (methodName === 'trace' && isIE) {
                return traceForIE;
            } else if (console[methodName] !== undefined) {
                return bindMethod(console, methodName);
            } else if (console.log !== undefined) {
                return bindMethod(console, 'log');
            } else {
                return noop;
            }
        }
    
        // These private functions always need `this` to be set properly
    
        function replaceLoggingMethods(level, loggerName) {
            /*jshint validthis:true */
            for (var i = 0; i < logMethods.length; i++) {
                var methodName = logMethods[i];
                this[methodName] = (i < level) ?
                    noop :
                    this.methodFactory(methodName, level, loggerName);
            }
    
            // Define log.log as an alias for log.debug
            this.log = this.debug;
        }
    
        // In old IE versions, the console isn't present until you first open it.
        // We build realMethod() replacements here that regenerate logging methods
        function enableLoggingWhenConsoleArrives(methodName, level, loggerName) {
            return function () {
                if (typeof console !== undefinedType) {
                    replaceLoggingMethods.call(this, level, loggerName);
                    this[methodName].apply(this, arguments);
                }
            };
        }
    
        // By default, we use closely bound real methods wherever possible, and
        // otherwise we wait for a console to appear, and then try again.
        function defaultMethodFactory(methodName, level, loggerName) {
            /*jshint validthis:true */
            return realMethod(methodName) ||
                   enableLoggingWhenConsoleArrives.apply(this, arguments);
        }
    
        function Logger(name, defaultLevel, factory) {
          var self = this;
          var currentLevel;
          var storageKey = "loglevel";
          if (name) {
            storageKey += ":" + name;
          }
    
          function persistLevelIfPossible(levelNum) {
              var levelName = (logMethods[levelNum] || 'silent').toUpperCase();
    
              if (typeof window === undefinedType) return;
    
              // Use localStorage if available
              try {
                  window.localStorage[storageKey] = levelName;
                  return;
              } catch (ignore) {}
    
              // Use session cookie as fallback
              try {
                  window.document.cookie =
                    encodeURIComponent(storageKey) + "=" + levelName + ";";
              } catch (ignore) {}
          }
    
          function getPersistedLevel() {
              var storedLevel;
    
              if (typeof window === undefinedType) return;
    
              try {
                  storedLevel = window.localStorage[storageKey];
              } catch (ignore) {}
    
              // Fallback to cookies if local storage gives us nothing
              if (typeof storedLevel === undefinedType) {
                  try {
                      var cookie = window.document.cookie;
                      var location = cookie.indexOf(
                          encodeURIComponent(storageKey) + "=");
                      if (location !== -1) {
                          storedLevel = /^([^;]+)/.exec(cookie.slice(location))[1];
                      }
                  } catch (ignore) {}
              }
    
              // If the stored level is not valid, treat it as if nothing was stored.
              if (self.levels[storedLevel] === undefined) {
                  storedLevel = undefined;
              }
    
              return storedLevel;
          }
    
          /*
           *
           * Public logger API - see https://github.com/pimterry/loglevel for details
           *
           */
    
          self.name = name;
    
          self.levels = { "TRACE": 0, "DEBUG": 1, "INFO": 2, "WARN": 3,
              "ERROR": 4, "SILENT": 5};
    
          self.methodFactory = factory || defaultMethodFactory;
    
          self.getLevel = function () {
              return currentLevel;
          };
    
          self.setLevel = function (level, persist) {
              if (typeof level === "string" && self.levels[level.toUpperCase()] !== undefined) {
                  level = self.levels[level.toUpperCase()];
              }
              if (typeof level === "number" && level >= 0 && level <= self.levels.SILENT) {
                  currentLevel = level;
                  if (persist !== false) {  // defaults to true
                      persistLevelIfPossible(level);
                  }
                  replaceLoggingMethods.call(self, level, name);
                  if (typeof console === undefinedType && level < self.levels.SILENT) {
                      return "No console available for logging";
                  }
              } else {
                  throw "log.setLevel() called with invalid level: " + level;
              }
          };
    
          self.setDefaultLevel = function (level) {
              if (!getPersistedLevel()) {
                  self.setLevel(level, false);
              }
          };
    
          self.enableAll = function(persist) {
              self.setLevel(self.levels.TRACE, persist);
          };
    
          self.disableAll = function(persist) {
              self.setLevel(self.levels.SILENT, persist);
          };
    
          // Initialize with the right level
          var initialLevel = getPersistedLevel();
          if (initialLevel == null) {
              initialLevel = defaultLevel == null ? "WARN" : defaultLevel;
          }
          self.setLevel(initialLevel, false);
        }
    
        /*
         *
         * Top-level API
         *
         */
    
        var defaultLogger = new Logger();
    
        var _loggersByName = {};
        defaultLogger.getLogger = function getLogger(name) {
            if (typeof name !== "string" || name === "") {
              throw new TypeError("You must supply a name when creating a logger.");
            }
    
            var logger = _loggersByName[name];
            if (!logger) {
              logger = _loggersByName[name] = new Logger(
                name, defaultLogger.getLevel(), defaultLogger.methodFactory);
            }
            return logger;
        };
    
        // Grab the current global log variable in case of overwrite
        var _log = (typeof window !== undefinedType) ? window.log : undefined;
        defaultLogger.noConflict = function() {
            if (typeof window !== undefinedType &&
                   window.log === defaultLogger) {
                window.log = _log;
            }
    
            return defaultLogger;
        };
    
        defaultLogger.getLoggers = function getLoggers() {
            return _loggersByName;
        };
    
        return defaultLogger;
    }));
    
    
    /***/ }),
    /* 33 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    
    var SockJS = __webpack_require__(34);
    
    var retries = 0;
    var sock = null;
    
    var socket = function initSocket(url, handlers) {
      sock = new SockJS(url);
    
      sock.onopen = function onopen() {
        retries = 0;
      };
    
      sock.onclose = function onclose() {
        if (retries === 0) {
          handlers.close();
        }
    
        // Try to reconnect.
        sock = null;
    
        // After 10 retries stop trying, to prevent logspam.
        if (retries <= 10) {
          // Exponentially increase timeout to reconnect.
          // Respectfully copied from the package `got`.
          // eslint-disable-next-line no-mixed-operators, no-restricted-properties
          var retryInMs = 1000 * Math.pow(2, retries) + Math.random() * 100;
          retries += 1;
    
          setTimeout(function () {
            socket(url, handlers);
          }, retryInMs);
        }
      };
    
      sock.onmessage = function onmessage(e) {
        // This assumes that all data sent via the websocket is JSON.
        var msg = JSON.parse(e.data);
        if (handlers[msg.type]) {
          handlers[msg.type](msg.data);
        }
      };
    };
    
    module.exports = socket;
    
    /***/ }),
    /* 34 */
    /***/ (function(module, exports, __webpack_require__) {
    
    /* WEBPACK VAR INJECTION */(function(global) {var require;var require;/* sockjs-client v1.1.5 | http://sockjs.org | MIT license */
    (function(f){if(true){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.SockJS = f()}})(function(){var define,module,exports;return (function(){function r(e,n,t){function o(i,f){if(!n[i]){if(!e[i]){var c="function"==typeof require&&require;if(!f&&c)return require(i,!0);if(u)return u(i,!0);var a=new Error("Cannot find module '"+i+"'");throw a.code="MODULE_NOT_FOUND",a}var p=n[i]={exports:{}};e[i][0].call(p.exports,function(r){var n=e[i][1][r];return o(n||r)},p,p.exports,r,e,n,t)}return n[i].exports}for(var u="function"==typeof require&&require,i=0;i<t.length;i++)o(t[i]);return o}return r})()({1:[function(require,module,exports){
    (function (global){
    'use strict';
    
    var transportList = require('./transport-list');
    
    module.exports = require('./main')(transportList);
    
    // TODO can't get rid of this until all servers do
    if ('_sockjs_onload' in global) {
      setTimeout(global._sockjs_onload, 1);
    }
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"./main":14,"./transport-list":16}],2:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , Event = require('./event')
      ;
    
    function CloseEvent() {
      Event.call(this);
      this.initEvent('close', false, false);
      this.wasClean = false;
      this.code = 0;
      this.reason = '';
    }
    
    inherits(CloseEvent, Event);
    
    module.exports = CloseEvent;
    
    },{"./event":4,"inherits":56}],3:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , EventTarget = require('./eventtarget')
      ;
    
    function EventEmitter() {
      EventTarget.call(this);
    }
    
    inherits(EventEmitter, EventTarget);
    
    EventEmitter.prototype.removeAllListeners = function(type) {
      if (type) {
        delete this._listeners[type];
      } else {
        this._listeners = {};
      }
    };
    
    EventEmitter.prototype.once = function(type, listener) {
      var self = this
        , fired = false;
    
      function g() {
        self.removeListener(type, g);
    
        if (!fired) {
          fired = true;
          listener.apply(this, arguments);
        }
      }
    
      this.on(type, g);
    };
    
    EventEmitter.prototype.emit = function() {
      var type = arguments[0];
      var listeners = this._listeners[type];
      if (!listeners) {
        return;
      }
      // equivalent of Array.prototype.slice.call(arguments, 1);
      var l = arguments.length;
      var args = new Array(l - 1);
      for (var ai = 1; ai < l; ai++) {
        args[ai - 1] = arguments[ai];
      }
      for (var i = 0; i < listeners.length; i++) {
        listeners[i].apply(this, args);
      }
    };
    
    EventEmitter.prototype.on = EventEmitter.prototype.addListener = EventTarget.prototype.addEventListener;
    EventEmitter.prototype.removeListener = EventTarget.prototype.removeEventListener;
    
    module.exports.EventEmitter = EventEmitter;
    
    },{"./eventtarget":5,"inherits":56}],4:[function(require,module,exports){
    'use strict';
    
    function Event(eventType) {
      this.type = eventType;
    }
    
    Event.prototype.initEvent = function(eventType, canBubble, cancelable) {
      this.type = eventType;
      this.bubbles = canBubble;
      this.cancelable = cancelable;
      this.timeStamp = +new Date();
      return this;
    };
    
    Event.prototype.stopPropagation = function() {};
    Event.prototype.preventDefault = function() {};
    
    Event.CAPTURING_PHASE = 1;
    Event.AT_TARGET = 2;
    Event.BUBBLING_PHASE = 3;
    
    module.exports = Event;
    
    },{}],5:[function(require,module,exports){
    'use strict';
    
    /* Simplified implementation of DOM2 EventTarget.
     *   http://www.w3.org/TR/DOM-Level-2-Events/events.html#Events-EventTarget
     */
    
    function EventTarget() {
      this._listeners = {};
    }
    
    EventTarget.prototype.addEventListener = function(eventType, listener) {
      if (!(eventType in this._listeners)) {
        this._listeners[eventType] = [];
      }
      var arr = this._listeners[eventType];
      // #4
      if (arr.indexOf(listener) === -1) {
        // Make a copy so as not to interfere with a current dispatchEvent.
        arr = arr.concat([listener]);
      }
      this._listeners[eventType] = arr;
    };
    
    EventTarget.prototype.removeEventListener = function(eventType, listener) {
      var arr = this._listeners[eventType];
      if (!arr) {
        return;
      }
      var idx = arr.indexOf(listener);
      if (idx !== -1) {
        if (arr.length > 1) {
          // Make a copy so as not to interfere with a current dispatchEvent.
          this._listeners[eventType] = arr.slice(0, idx).concat(arr.slice(idx + 1));
        } else {
          delete this._listeners[eventType];
        }
        return;
      }
    };
    
    EventTarget.prototype.dispatchEvent = function() {
      var event = arguments[0];
      var t = event.type;
      // equivalent of Array.prototype.slice.call(arguments, 0);
      var args = arguments.length === 1 ? [event] : Array.apply(null, arguments);
      // TODO: This doesn't match the real behavior; per spec, onfoo get
      // their place in line from the /first/ time they're set from
      // non-null. Although WebKit bumps it to the end every time it's
      // set.
      if (this['on' + t]) {
        this['on' + t].apply(this, args);
      }
      if (t in this._listeners) {
        // Grab a reference to the listeners list. removeEventListener may alter the list.
        var listeners = this._listeners[t];
        for (var i = 0; i < listeners.length; i++) {
          listeners[i].apply(this, args);
        }
      }
    };
    
    module.exports = EventTarget;
    
    },{}],6:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , Event = require('./event')
      ;
    
    function TransportMessageEvent(data) {
      Event.call(this);
      this.initEvent('message', false, false);
      this.data = data;
    }
    
    inherits(TransportMessageEvent, Event);
    
    module.exports = TransportMessageEvent;
    
    },{"./event":4,"inherits":56}],7:[function(require,module,exports){
    'use strict';
    
    var JSON3 = require('json3')
      , iframeUtils = require('./utils/iframe')
      ;
    
    function FacadeJS(transport) {
      this._transport = transport;
      transport.on('message', this._transportMessage.bind(this));
      transport.on('close', this._transportClose.bind(this));
    }
    
    FacadeJS.prototype._transportClose = function(code, reason) {
      iframeUtils.postMessage('c', JSON3.stringify([code, reason]));
    };
    FacadeJS.prototype._transportMessage = function(frame) {
      iframeUtils.postMessage('t', frame);
    };
    FacadeJS.prototype._send = function(data) {
      this._transport.send(data);
    };
    FacadeJS.prototype._close = function() {
      this._transport.close();
      this._transport.removeAllListeners();
    };
    
    module.exports = FacadeJS;
    
    },{"./utils/iframe":47,"json3":57}],8:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var urlUtils = require('./utils/url')
      , eventUtils = require('./utils/event')
      , JSON3 = require('json3')
      , FacadeJS = require('./facade')
      , InfoIframeReceiver = require('./info-iframe-receiver')
      , iframeUtils = require('./utils/iframe')
      , loc = require('./location')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:iframe-bootstrap');
    }
    
    module.exports = function(SockJS, availableTransports) {
      var transportMap = {};
      availableTransports.forEach(function(at) {
        if (at.facadeTransport) {
          transportMap[at.facadeTransport.transportName] = at.facadeTransport;
        }
      });
    
      // hard-coded for the info iframe
      // TODO see if we can make this more dynamic
      transportMap[InfoIframeReceiver.transportName] = InfoIframeReceiver;
      var parentOrigin;
    
      /* eslint-disable camelcase */
      SockJS.bootstrap_iframe = function() {
        /* eslint-enable camelcase */
        var facade;
        iframeUtils.currentWindowId = loc.hash.slice(1);
        var onMessage = function(e) {
          if (e.source !== parent) {
            return;
          }
          if (typeof parentOrigin === 'undefined') {
            parentOrigin = e.origin;
          }
          if (e.origin !== parentOrigin) {
            return;
          }
    
          var iframeMessage;
          try {
            iframeMessage = JSON3.parse(e.data);
          } catch (ignored) {
            debug('bad json', e.data);
            return;
          }
    
          if (iframeMessage.windowId !== iframeUtils.currentWindowId) {
            return;
          }
          switch (iframeMessage.type) {
          case 's':
            var p;
            try {
              p = JSON3.parse(iframeMessage.data);
            } catch (ignored) {
              debug('bad json', iframeMessage.data);
              break;
            }
            var version = p[0];
            var transport = p[1];
            var transUrl = p[2];
            var baseUrl = p[3];
            debug(version, transport, transUrl, baseUrl);
            // change this to semver logic
            if (version !== SockJS.version) {
              throw new Error('Incompatible SockJS! Main site uses:' +
                        ' "' + version + '", the iframe:' +
                        ' "' + SockJS.version + '".');
            }
    
            if (!urlUtils.isOriginEqual(transUrl, loc.href) ||
                !urlUtils.isOriginEqual(baseUrl, loc.href)) {
              throw new Error('Can\'t connect to different domain from within an ' +
                        'iframe. (' + loc.href + ', ' + transUrl + ', ' + baseUrl + ')');
            }
            facade = new FacadeJS(new transportMap[transport](transUrl, baseUrl));
            break;
          case 'm':
            facade._send(iframeMessage.data);
            break;
          case 'c':
            if (facade) {
              facade._close();
            }
            facade = null;
            break;
          }
        };
    
        eventUtils.attachEvent('message', onMessage);
    
        // Start
        iframeUtils.postMessage('s');
      };
    };
    
    }).call(this,{ env: {} })
    
    },{"./facade":7,"./info-iframe-receiver":10,"./location":13,"./utils/event":46,"./utils/iframe":47,"./utils/url":52,"debug":54,"json3":57}],9:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var EventEmitter = require('events').EventEmitter
      , inherits = require('inherits')
      , JSON3 = require('json3')
      , objectUtils = require('./utils/object')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:info-ajax');
    }
    
    function InfoAjax(url, AjaxObject) {
      EventEmitter.call(this);
    
      var self = this;
      var t0 = +new Date();
      this.xo = new AjaxObject('GET', url);
    
      this.xo.once('finish', function(status, text) {
        var info, rtt;
        if (status === 200) {
          rtt = (+new Date()) - t0;
          if (text) {
            try {
              info = JSON3.parse(text);
            } catch (e) {
              debug('bad json', text);
            }
          }
    
          if (!objectUtils.isObject(info)) {
            info = {};
          }
        }
        self.emit('finish', info, rtt);
        self.removeAllListeners();
      });
    }
    
    inherits(InfoAjax, EventEmitter);
    
    InfoAjax.prototype.close = function() {
      this.removeAllListeners();
      this.xo.close();
    };
    
    module.exports = InfoAjax;
    
    }).call(this,{ env: {} })
    
    },{"./utils/object":49,"debug":54,"events":3,"inherits":56,"json3":57}],10:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , EventEmitter = require('events').EventEmitter
      , JSON3 = require('json3')
      , XHRLocalObject = require('./transport/sender/xhr-local')
      , InfoAjax = require('./info-ajax')
      ;
    
    function InfoReceiverIframe(transUrl) {
      var self = this;
      EventEmitter.call(this);
    
      this.ir = new InfoAjax(transUrl, XHRLocalObject);
      this.ir.once('finish', function(info, rtt) {
        self.ir = null;
        self.emit('message', JSON3.stringify([info, rtt]));
      });
    }
    
    inherits(InfoReceiverIframe, EventEmitter);
    
    InfoReceiverIframe.transportName = 'iframe-info-receiver';
    
    InfoReceiverIframe.prototype.close = function() {
      if (this.ir) {
        this.ir.close();
        this.ir = null;
      }
      this.removeAllListeners();
    };
    
    module.exports = InfoReceiverIframe;
    
    },{"./info-ajax":9,"./transport/sender/xhr-local":37,"events":3,"inherits":56,"json3":57}],11:[function(require,module,exports){
    (function (process,global){
    'use strict';
    
    var EventEmitter = require('events').EventEmitter
      , inherits = require('inherits')
      , JSON3 = require('json3')
      , utils = require('./utils/event')
      , IframeTransport = require('./transport/iframe')
      , InfoReceiverIframe = require('./info-iframe-receiver')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:info-iframe');
    }
    
    function InfoIframe(baseUrl, url) {
      var self = this;
      EventEmitter.call(this);
    
      var go = function() {
        var ifr = self.ifr = new IframeTransport(InfoReceiverIframe.transportName, url, baseUrl);
    
        ifr.once('message', function(msg) {
          if (msg) {
            var d;
            try {
              d = JSON3.parse(msg);
            } catch (e) {
              debug('bad json', msg);
              self.emit('finish');
              self.close();
              return;
            }
    
            var info = d[0], rtt = d[1];
            self.emit('finish', info, rtt);
          }
          self.close();
        });
    
        ifr.once('close', function() {
          self.emit('finish');
          self.close();
        });
      };
    
      // TODO this seems the same as the 'needBody' from transports
      if (!global.document.body) {
        utils.attachEvent('load', go);
      } else {
        go();
      }
    }
    
    inherits(InfoIframe, EventEmitter);
    
    InfoIframe.enabled = function() {
      return IframeTransport.enabled();
    };
    
    InfoIframe.prototype.close = function() {
      if (this.ifr) {
        this.ifr.close();
      }
      this.removeAllListeners();
      this.ifr = null;
    };
    
    module.exports = InfoIframe;
    
    }).call(this,{ env: {} },typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"./info-iframe-receiver":10,"./transport/iframe":22,"./utils/event":46,"debug":54,"events":3,"inherits":56,"json3":57}],12:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var EventEmitter = require('events').EventEmitter
      , inherits = require('inherits')
      , urlUtils = require('./utils/url')
      , XDR = require('./transport/sender/xdr')
      , XHRCors = require('./transport/sender/xhr-cors')
      , XHRLocal = require('./transport/sender/xhr-local')
      , XHRFake = require('./transport/sender/xhr-fake')
      , InfoIframe = require('./info-iframe')
      , InfoAjax = require('./info-ajax')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:info-receiver');
    }
    
    function InfoReceiver(baseUrl, urlInfo) {
      debug(baseUrl);
      var self = this;
      EventEmitter.call(this);
    
      setTimeout(function() {
        self.doXhr(baseUrl, urlInfo);
      }, 0);
    }
    
    inherits(InfoReceiver, EventEmitter);
    
    // TODO this is currently ignoring the list of available transports and the whitelist
    
    InfoReceiver._getReceiver = function(baseUrl, url, urlInfo) {
      // determine method of CORS support (if needed)
      if (urlInfo.sameOrigin) {
        return new InfoAjax(url, XHRLocal);
      }
      if (XHRCors.enabled) {
        return new InfoAjax(url, XHRCors);
      }
      if (XDR.enabled && urlInfo.sameScheme) {
        return new InfoAjax(url, XDR);
      }
      if (InfoIframe.enabled()) {
        return new InfoIframe(baseUrl, url);
      }
      return new InfoAjax(url, XHRFake);
    };
    
    InfoReceiver.prototype.doXhr = function(baseUrl, urlInfo) {
      var self = this
        , url = urlUtils.addPath(baseUrl, '/info')
        ;
      debug('doXhr', url);
    
      this.xo = InfoReceiver._getReceiver(baseUrl, url, urlInfo);
    
      this.timeoutRef = setTimeout(function() {
        debug('timeout');
        self._cleanup(false);
        self.emit('finish');
      }, InfoReceiver.timeout);
    
      this.xo.once('finish', function(info, rtt) {
        debug('finish', info, rtt);
        self._cleanup(true);
        self.emit('finish', info, rtt);
      });
    };
    
    InfoReceiver.prototype._cleanup = function(wasClean) {
      debug('_cleanup');
      clearTimeout(this.timeoutRef);
      this.timeoutRef = null;
      if (!wasClean && this.xo) {
        this.xo.close();
      }
      this.xo = null;
    };
    
    InfoReceiver.prototype.close = function() {
      debug('close');
      this.removeAllListeners();
      this._cleanup(false);
    };
    
    InfoReceiver.timeout = 8000;
    
    module.exports = InfoReceiver;
    
    }).call(this,{ env: {} })
    
    },{"./info-ajax":9,"./info-iframe":11,"./transport/sender/xdr":34,"./transport/sender/xhr-cors":35,"./transport/sender/xhr-fake":36,"./transport/sender/xhr-local":37,"./utils/url":52,"debug":54,"events":3,"inherits":56}],13:[function(require,module,exports){
    (function (global){
    'use strict';
    
    module.exports = global.location || {
      origin: 'http://localhost:80'
    , protocol: 'http:'
    , host: 'localhost'
    , port: 80
    , href: 'http://localhost/'
    , hash: ''
    };
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{}],14:[function(require,module,exports){
    (function (process,global){
    'use strict';
    
    require('./shims');
    
    var URL = require('url-parse')
      , inherits = require('inherits')
      , JSON3 = require('json3')
      , random = require('./utils/random')
      , escape = require('./utils/escape')
      , urlUtils = require('./utils/url')
      , eventUtils = require('./utils/event')
      , transport = require('./utils/transport')
      , objectUtils = require('./utils/object')
      , browser = require('./utils/browser')
      , log = require('./utils/log')
      , Event = require('./event/event')
      , EventTarget = require('./event/eventtarget')
      , loc = require('./location')
      , CloseEvent = require('./event/close')
      , TransportMessageEvent = require('./event/trans-message')
      , InfoReceiver = require('./info-receiver')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:main');
    }
    
    var transports;
    
    // follow constructor steps defined at http://dev.w3.org/html5/websockets/#the-websocket-interface
    function SockJS(url, protocols, options) {
      if (!(this instanceof SockJS)) {
        return new SockJS(url, protocols, options);
      }
      if (arguments.length < 1) {
        throw new TypeError("Failed to construct 'SockJS: 1 argument required, but only 0 present");
      }
      EventTarget.call(this);
    
      this.readyState = SockJS.CONNECTING;
      this.extensions = '';
      this.protocol = '';
    
      // non-standard extension
      options = options || {};
      if (options.protocols_whitelist) {
        log.warn("'protocols_whitelist' is DEPRECATED. Use 'transports' instead.");
      }
      this._transportsWhitelist = options.transports;
      this._transportOptions = options.transportOptions || {};
    
      var sessionId = options.sessionId || 8;
      if (typeof sessionId === 'function') {
        this._generateSessionId = sessionId;
      } else if (typeof sessionId === 'number') {
        this._generateSessionId = function() {
          return random.string(sessionId);
        };
      } else {
        throw new TypeError('If sessionId is used in the options, it needs to be a number or a function.');
      }
    
      this._server = options.server || random.numberString(1000);
    
      // Step 1 of WS spec - parse and validate the url. Issue #8
      var parsedUrl = new URL(url);
      if (!parsedUrl.host || !parsedUrl.protocol) {
        throw new SyntaxError("The URL '" + url + "' is invalid");
      } else if (parsedUrl.hash) {
        throw new SyntaxError('The URL must not contain a fragment');
      } else if (parsedUrl.protocol !== 'http:' && parsedUrl.protocol !== 'https:') {
        throw new SyntaxError("The URL's scheme must be either 'http:' or 'https:'. '" + parsedUrl.protocol + "' is not allowed.");
      }
    
      var secure = parsedUrl.protocol === 'https:';
      // Step 2 - don't allow secure origin with an insecure protocol
      if (loc.protocol === 'https:' && !secure) {
        throw new Error('SecurityError: An insecure SockJS connection may not be initiated from a page loaded over HTTPS');
      }
    
      // Step 3 - check port access - no need here
      // Step 4 - parse protocols argument
      if (!protocols) {
        protocols = [];
      } else if (!Array.isArray(protocols)) {
        protocols = [protocols];
      }
    
      // Step 5 - check protocols argument
      var sortedProtocols = protocols.sort();
      sortedProtocols.forEach(function(proto, i) {
        if (!proto) {
          throw new SyntaxError("The protocols entry '" + proto + "' is invalid.");
        }
        if (i < (sortedProtocols.length - 1) && proto === sortedProtocols[i + 1]) {
          throw new SyntaxError("The protocols entry '" + proto + "' is duplicated.");
        }
      });
    
      // Step 6 - convert origin
      var o = urlUtils.getOrigin(loc.href);
      this._origin = o ? o.toLowerCase() : null;
    
      // remove the trailing slash
      parsedUrl.set('pathname', parsedUrl.pathname.replace(/\/+$/, ''));
    
      // store the sanitized url
      this.url = parsedUrl.href;
      debug('using url', this.url);
    
      // Step 7 - start connection in background
      // obtain server info
      // http://sockjs.github.io/sockjs-protocol/sockjs-protocol-0.3.3.html#section-26
      this._urlInfo = {
        nullOrigin: !browser.hasDomain()
      , sameOrigin: urlUtils.isOriginEqual(this.url, loc.href)
      , sameScheme: urlUtils.isSchemeEqual(this.url, loc.href)
      };
    
      this._ir = new InfoReceiver(this.url, this._urlInfo);
      this._ir.once('finish', this._receiveInfo.bind(this));
    }
    
    inherits(SockJS, EventTarget);
    
    function userSetCode(code) {
      return code === 1000 || (code >= 3000 && code <= 4999);
    }
    
    SockJS.prototype.close = function(code, reason) {
      // Step 1
      if (code && !userSetCode(code)) {
        throw new Error('InvalidAccessError: Invalid code');
      }
      // Step 2.4 states the max is 123 bytes, but we are just checking length
      if (reason && reason.length > 123) {
        throw new SyntaxError('reason argument has an invalid length');
      }
    
      // Step 3.1
      if (this.readyState === SockJS.CLOSING || this.readyState === SockJS.CLOSED) {
        return;
      }
    
      // TODO look at docs to determine how to set this
      var wasClean = true;
      this._close(code || 1000, reason || 'Normal closure', wasClean);
    };
    
    SockJS.prototype.send = function(data) {
      // #13 - convert anything non-string to string
      // TODO this currently turns objects into [object Object]
      if (typeof data !== 'string') {
        data = '' + data;
      }
      if (this.readyState === SockJS.CONNECTING) {
        throw new Error('InvalidStateError: The connection has not been established yet');
      }
      if (this.readyState !== SockJS.OPEN) {
        return;
      }
      this._transport.send(escape.quote(data));
    };
    
    SockJS.version = require('./version');
    
    SockJS.CONNECTING = 0;
    SockJS.OPEN = 1;
    SockJS.CLOSING = 2;
    SockJS.CLOSED = 3;
    
    SockJS.prototype._receiveInfo = function(info, rtt) {
      debug('_receiveInfo', rtt);
      this._ir = null;
      if (!info) {
        this._close(1002, 'Cannot connect to server');
        return;
      }
    
      // establish a round-trip timeout (RTO) based on the
      // round-trip time (RTT)
      this._rto = this.countRTO(rtt);
      // allow server to override url used for the actual transport
      this._transUrl = info.base_url ? info.base_url : this.url;
      info = objectUtils.extend(info, this._urlInfo);
      debug('info', info);
      // determine list of desired and supported transports
      var enabledTransports = transports.filterToEnabled(this._transportsWhitelist, info);
      this._transports = enabledTransports.main;
      debug(this._transports.length + ' enabled transports');
    
      this._connect();
    };
    
    SockJS.prototype._connect = function() {
      for (var Transport = this._transports.shift(); Transport; Transport = this._transports.shift()) {
        debug('attempt', Transport.transportName);
        if (Transport.needBody) {
          if (!global.document.body ||
              (typeof global.document.readyState !== 'undefined' &&
                global.document.readyState !== 'complete' &&
                global.document.readyState !== 'interactive')) {
            debug('waiting for body');
            this._transports.unshift(Transport);
            eventUtils.attachEvent('load', this._connect.bind(this));
            return;
          }
        }
    
        // calculate timeout based on RTO and round trips. Default to 5s
        var timeoutMs = (this._rto * Transport.roundTrips) || 5000;
        this._transportTimeoutId = setTimeout(this._transportTimeout.bind(this), timeoutMs);
        debug('using timeout', timeoutMs);
    
        var transportUrl = urlUtils.addPath(this._transUrl, '/' + this._server + '/' + this._generateSessionId());
        var options = this._transportOptions[Transport.transportName];
        debug('transport url', transportUrl);
        var transportObj = new Transport(transportUrl, this._transUrl, options);
        transportObj.on('message', this._transportMessage.bind(this));
        transportObj.once('close', this._transportClose.bind(this));
        transportObj.transportName = Transport.transportName;
        this._transport = transportObj;
    
        return;
      }
      this._close(2000, 'All transports failed', false);
    };
    
    SockJS.prototype._transportTimeout = function() {
      debug('_transportTimeout');
      if (this.readyState === SockJS.CONNECTING) {
        if (this._transport) {
          this._transport.close();
        }
    
        this._transportClose(2007, 'Transport timed out');
      }
    };
    
    SockJS.prototype._transportMessage = function(msg) {
      debug('_transportMessage', msg);
      var self = this
        , type = msg.slice(0, 1)
        , content = msg.slice(1)
        , payload
        ;
    
      // first check for messages that don't need a payload
      switch (type) {
        case 'o':
          this._open();
          return;
        case 'h':
          this.dispatchEvent(new Event('heartbeat'));
          debug('heartbeat', this.transport);
          return;
      }
    
      if (content) {
        try {
          payload = JSON3.parse(content);
        } catch (e) {
          debug('bad json', content);
        }
      }
    
      if (typeof payload === 'undefined') {
        debug('empty payload', content);
        return;
      }
    
      switch (type) {
        case 'a':
          if (Array.isArray(payload)) {
            payload.forEach(function(p) {
              debug('message', self.transport, p);
              self.dispatchEvent(new TransportMessageEvent(p));
            });
          }
          break;
        case 'm':
          debug('message', this.transport, payload);
          this.dispatchEvent(new TransportMessageEvent(payload));
          break;
        case 'c':
          if (Array.isArray(payload) && payload.length === 2) {
            this._close(payload[0], payload[1], true);
          }
          break;
      }
    };
    
    SockJS.prototype._transportClose = function(code, reason) {
      debug('_transportClose', this.transport, code, reason);
      if (this._transport) {
        this._transport.removeAllListeners();
        this._transport = null;
        this.transport = null;
      }
    
      if (!userSetCode(code) && code !== 2000 && this.readyState === SockJS.CONNECTING) {
        this._connect();
        return;
      }
    
      this._close(code, reason);
    };
    
    SockJS.prototype._open = function() {
      debug('_open', this._transport.transportName, this.readyState);
      if (this.readyState === SockJS.CONNECTING) {
        if (this._transportTimeoutId) {
          clearTimeout(this._transportTimeoutId);
          this._transportTimeoutId = null;
        }
        this.readyState = SockJS.OPEN;
        this.transport = this._transport.transportName;
        this.dispatchEvent(new Event('open'));
        debug('connected', this.transport);
      } else {
        // The server might have been restarted, and lost track of our
        // connection.
        this._close(1006, 'Server lost session');
      }
    };
    
    SockJS.prototype._close = function(code, reason, wasClean) {
      debug('_close', this.transport, code, reason, wasClean, this.readyState);
      var forceFail = false;
    
      if (this._ir) {
        forceFail = true;
        this._ir.close();
        this._ir = null;
      }
      if (this._transport) {
        this._transport.close();
        this._transport = null;
        this.transport = null;
      }
    
      if (this.readyState === SockJS.CLOSED) {
        throw new Error('InvalidStateError: SockJS has already been closed');
      }
    
      this.readyState = SockJS.CLOSING;
      setTimeout(function() {
        this.readyState = SockJS.CLOSED;
    
        if (forceFail) {
          this.dispatchEvent(new Event('error'));
        }
    
        var e = new CloseEvent('close');
        e.wasClean = wasClean || false;
        e.code = code || 1000;
        e.reason = reason;
    
        this.dispatchEvent(e);
        this.onmessage = this.onclose = this.onerror = null;
        debug('disconnected');
      }.bind(this), 0);
    };
    
    // See: http://www.erg.abdn.ac.uk/~gerrit/dccp/notes/ccid2/rto_estimator/
    // and RFC 2988.
    SockJS.prototype.countRTO = function(rtt) {
      // In a local environment, when using IE8/9 and the `jsonp-polling`
      // transport the time needed to establish a connection (the time that pass
      // from the opening of the transport to the call of `_dispatchOpen`) is
      // around 200msec (the lower bound used in the article above) and this
      // causes spurious timeouts. For this reason we calculate a value slightly
      // larger than that used in the article.
      if (rtt > 100) {
        return 4 * rtt; // rto > 400msec
      }
      return 300 + rtt; // 300msec < rto <= 400msec
    };
    
    module.exports = function(availableTransports) {
      transports = transport(availableTransports);
      require('./iframe-bootstrap')(SockJS, availableTransports);
      return SockJS;
    };
    
    }).call(this,{ env: {} },typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"./event/close":2,"./event/event":4,"./event/eventtarget":5,"./event/trans-message":6,"./iframe-bootstrap":8,"./info-receiver":12,"./location":13,"./shims":15,"./utils/browser":44,"./utils/escape":45,"./utils/event":46,"./utils/log":48,"./utils/object":49,"./utils/random":50,"./utils/transport":51,"./utils/url":52,"./version":53,"debug":54,"inherits":56,"json3":57,"url-parse":61}],15:[function(require,module,exports){
    /* eslint-disable */
    /* jscs: disable */
    'use strict';
    
    // pulled specific shims from https://github.com/es-shims/es5-shim
    
    var ArrayPrototype = Array.prototype;
    var ObjectPrototype = Object.prototype;
    var FunctionPrototype = Function.prototype;
    var StringPrototype = String.prototype;
    var array_slice = ArrayPrototype.slice;
    
    var _toString = ObjectPrototype.toString;
    var isFunction = function (val) {
        return ObjectPrototype.toString.call(val) === '[object Function]';
    };
    var isArray = function isArray(obj) {
        return _toString.call(obj) === '[object Array]';
    };
    var isString = function isString(obj) {
        return _toString.call(obj) === '[object String]';
    };
    
    var supportsDescriptors = Object.defineProperty && (function () {
        try {
            Object.defineProperty({}, 'x', {});
            return true;
        } catch (e) { /* this is ES3 */
            return false;
        }
    }());
    
    // Define configurable, writable and non-enumerable props
    // if they don't exist.
    var defineProperty;
    if (supportsDescriptors) {
        defineProperty = function (object, name, method, forceAssign) {
            if (!forceAssign && (name in object)) { return; }
            Object.defineProperty(object, name, {
                configurable: true,
                enumerable: false,
                writable: true,
                value: method
            });
        };
    } else {
        defineProperty = function (object, name, method, forceAssign) {
            if (!forceAssign && (name in object)) { return; }
            object[name] = method;
        };
    }
    var defineProperties = function (object, map, forceAssign) {
        for (var name in map) {
            if (ObjectPrototype.hasOwnProperty.call(map, name)) {
              defineProperty(object, name, map[name], forceAssign);
            }
        }
    };
    
    var toObject = function (o) {
        if (o == null) { // this matches both null and undefined
            throw new TypeError("can't convert " + o + ' to object');
        }
        return Object(o);
    };
    
    //
    // Util
    // ======
    //
    
    // ES5 9.4
    // http://es5.github.com/#x9.4
    // http://jsperf.com/to-integer
    
    function toInteger(num) {
        var n = +num;
        if (n !== n) { // isNaN
            n = 0;
        } else if (n !== 0 && n !== (1 / 0) && n !== -(1 / 0)) {
            n = (n > 0 || -1) * Math.floor(Math.abs(n));
        }
        return n;
    }
    
    function ToUint32(x) {
        return x >>> 0;
    }
    
    //
    // Function
    // ========
    //
    
    // ES-5 15.3.4.5
    // http://es5.github.com/#x15.3.4.5
    
    function Empty() {}
    
    defineProperties(FunctionPrototype, {
        bind: function bind(that) { // .length is 1
            // 1. Let Target be the this value.
            var target = this;
            // 2. If IsCallable(Target) is false, throw a TypeError exception.
            if (!isFunction(target)) {
                throw new TypeError('Function.prototype.bind called on incompatible ' + target);
            }
            // 3. Let A be a new (possibly empty) internal list of all of the
            //   argument values provided after thisArg (arg1, arg2 etc), in order.
            // XXX slicedArgs will stand in for "A" if used
            var args = array_slice.call(arguments, 1); // for normal call
            // 4. Let F be a new native ECMAScript object.
            // 11. Set the [[Prototype]] internal property of F to the standard
            //   built-in Function prototype object as specified in 15.3.3.1.
            // 12. Set the [[Call]] internal property of F as described in
            //   15.3.4.5.1.
            // 13. Set the [[Construct]] internal property of F as described in
            //   15.3.4.5.2.
            // 14. Set the [[HasInstance]] internal property of F as described in
            //   15.3.4.5.3.
            var binder = function () {
    
                if (this instanceof bound) {
                    // 15.3.4.5.2 [[Construct]]
                    // When the [[Construct]] internal method of a function object,
                    // F that was created using the bind function is called with a
                    // list of arguments ExtraArgs, the following steps are taken:
                    // 1. Let target be the value of F's [[TargetFunction]]
                    //   internal property.
                    // 2. If target has no [[Construct]] internal method, a
                    //   TypeError exception is thrown.
                    // 3. Let boundArgs be the value of F's [[BoundArgs]] internal
                    //   property.
                    // 4. Let args be a new list containing the same values as the
                    //   list boundArgs in the same order followed by the same
                    //   values as the list ExtraArgs in the same order.
                    // 5. Return the result of calling the [[Construct]] internal
                    //   method of target providing args as the arguments.
    
                    var result = target.apply(
                        this,
                        args.concat(array_slice.call(arguments))
                    );
                    if (Object(result) === result) {
                        return result;
                    }
                    return this;
    
                } else {
                    // 15.3.4.5.1 [[Call]]
                    // When the [[Call]] internal method of a function object, F,
                    // which was created using the bind function is called with a
                    // this value and a list of arguments ExtraArgs, the following
                    // steps are taken:
                    // 1. Let boundArgs be the value of F's [[BoundArgs]] internal
                    //   property.
                    // 2. Let boundThis be the value of F's [[BoundThis]] internal
                    //   property.
                    // 3. Let target be the value of F's [[TargetFunction]] internal
                    //   property.
                    // 4. Let args be a new list containing the same values as the
                    //   list boundArgs in the same order followed by the same
                    //   values as the list ExtraArgs in the same order.
                    // 5. Return the result of calling the [[Call]] internal method
                    //   of target providing boundThis as the this value and
                    //   providing args as the arguments.
    
                    // equiv: target.call(this, ...boundArgs, ...args)
                    return target.apply(
                        that,
                        args.concat(array_slice.call(arguments))
                    );
    
                }
    
            };
    
            // 15. If the [[Class]] internal property of Target is "Function", then
            //     a. Let L be the length property of Target minus the length of A.
            //     b. Set the length own property of F to either 0 or L, whichever is
            //       larger.
            // 16. Else set the length own property of F to 0.
    
            var boundLength = Math.max(0, target.length - args.length);
    
            // 17. Set the attributes of the length own property of F to the values
            //   specified in 15.3.5.1.
            var boundArgs = [];
            for (var i = 0; i < boundLength; i++) {
                boundArgs.push('$' + i);
            }
    
            // XXX Build a dynamic function with desired amount of arguments is the only
            // way to set the length property of a function.
            // In environments where Content Security Policies enabled (Chrome extensions,
            // for ex.) all use of eval or Function costructor throws an exception.
            // However in all of these environments Function.prototype.bind exists
            // and so this code will never be executed.
            var bound = Function('binder', 'return function (' + boundArgs.join(',') + '){ return binder.apply(this, arguments); }')(binder);
    
            if (target.prototype) {
                Empty.prototype = target.prototype;
                bound.prototype = new Empty();
                // Clean up dangling references.
                Empty.prototype = null;
            }
    
            // TODO
            // 18. Set the [[Extensible]] internal property of F to true.
    
            // TODO
            // 19. Let thrower be the [[ThrowTypeError]] function Object (13.2.3).
            // 20. Call the [[DefineOwnProperty]] internal method of F with
            //   arguments "caller", PropertyDescriptor {[[Get]]: thrower, [[Set]]:
            //   thrower, [[Enumerable]]: false, [[Configurable]]: false}, and
            //   false.
            // 21. Call the [[DefineOwnProperty]] internal method of F with
            //   arguments "arguments", PropertyDescriptor {[[Get]]: thrower,
            //   [[Set]]: thrower, [[Enumerable]]: false, [[Configurable]]: false},
            //   and false.
    
            // TODO
            // NOTE Function objects created using Function.prototype.bind do not
            // have a prototype property or the [[Code]], [[FormalParameters]], and
            // [[Scope]] internal properties.
            // XXX can't delete prototype in pure-js.
    
            // 22. Return F.
            return bound;
        }
    });
    
    //
    // Array
    // =====
    //
    
    // ES5 15.4.3.2
    // http://es5.github.com/#x15.4.3.2
    // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/isArray
    defineProperties(Array, { isArray: isArray });
    
    
    var boxedString = Object('a');
    var splitString = boxedString[0] !== 'a' || !(0 in boxedString);
    
    var properlyBoxesContext = function properlyBoxed(method) {
        // Check node 0.6.21 bug where third parameter is not boxed
        var properlyBoxesNonStrict = true;
        var properlyBoxesStrict = true;
        if (method) {
            method.call('foo', function (_, __, context) {
                if (typeof context !== 'object') { properlyBoxesNonStrict = false; }
            });
    
            method.call([1], function () {
                'use strict';
                properlyBoxesStrict = typeof this === 'string';
            }, 'x');
        }
        return !!method && properlyBoxesNonStrict && properlyBoxesStrict;
    };
    
    defineProperties(ArrayPrototype, {
        forEach: function forEach(fun /*, thisp*/) {
            var object = toObject(this),
                self = splitString && isString(this) ? this.split('') : object,
                thisp = arguments[1],
                i = -1,
                length = self.length >>> 0;
    
            // If no callback function or if callback is not a callable function
            if (!isFunction(fun)) {
                throw new TypeError(); // TODO message
            }
    
            while (++i < length) {
                if (i in self) {
                    // Invoke the callback function with call, passing arguments:
                    // context, property value, property key, thisArg object
                    // context
                    fun.call(thisp, self[i], i, object);
                }
            }
        }
    }, !properlyBoxesContext(ArrayPrototype.forEach));
    
    // ES5 15.4.4.14
    // http://es5.github.com/#x15.4.4.14
    // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/Array/indexOf
    var hasFirefox2IndexOfBug = Array.prototype.indexOf && [0, 1].indexOf(1, 2) !== -1;
    defineProperties(ArrayPrototype, {
        indexOf: function indexOf(sought /*, fromIndex */ ) {
            var self = splitString && isString(this) ? this.split('') : toObject(this),
                length = self.length >>> 0;
    
            if (!length) {
                return -1;
            }
    
            var i = 0;
            if (arguments.length > 1) {
                i = toInteger(arguments[1]);
            }
    
            // handle negative indices
            i = i >= 0 ? i : Math.max(0, length + i);
            for (; i < length; i++) {
                if (i in self && self[i] === sought) {
                    return i;
                }
            }
            return -1;
        }
    }, hasFirefox2IndexOfBug);
    
    //
    // String
    // ======
    //
    
    // ES5 15.5.4.14
    // http://es5.github.com/#x15.5.4.14
    
    // [bugfix, IE lt 9, firefox 4, Konqueror, Opera, obscure browsers]
    // Many browsers do not split properly with regular expressions or they
    // do not perform the split correctly under obscure conditions.
    // See http://blog.stevenlevithan.com/archives/cross-browser-split
    // I've tested in many browsers and this seems to cover the deviant ones:
    //    'ab'.split(/(?:ab)*/) should be ["", ""], not [""]
    //    '.'.split(/(.?)(.?)/) should be ["", ".", "", ""], not ["", ""]
    //    'tesst'.split(/(s)*/) should be ["t", undefined, "e", "s", "t"], not
    //       [undefined, "t", undefined, "e", ...]
    //    ''.split(/.?/) should be [], not [""]
    //    '.'.split(/()()/) should be ["."], not ["", "", "."]
    
    var string_split = StringPrototype.split;
    if (
        'ab'.split(/(?:ab)*/).length !== 2 ||
        '.'.split(/(.?)(.?)/).length !== 4 ||
        'tesst'.split(/(s)*/)[1] === 't' ||
        'test'.split(/(?:)/, -1).length !== 4 ||
        ''.split(/.?/).length ||
        '.'.split(/()()/).length > 1
    ) {
        (function () {
            var compliantExecNpcg = /()??/.exec('')[1] === void 0; // NPCG: nonparticipating capturing group
    
            StringPrototype.split = function (separator, limit) {
                var string = this;
                if (separator === void 0 && limit === 0) {
                    return [];
                }
    
                // If `separator` is not a regex, use native split
                if (_toString.call(separator) !== '[object RegExp]') {
                    return string_split.call(this, separator, limit);
                }
    
                var output = [],
                    flags = (separator.ignoreCase ? 'i' : '') +
                            (separator.multiline  ? 'm' : '') +
                            (separator.extended   ? 'x' : '') + // Proposed for ES6
                            (separator.sticky     ? 'y' : ''), // Firefox 3+
                    lastLastIndex = 0,
                    // Make `global` and avoid `lastIndex` issues by working with a copy
                    separator2, match, lastIndex, lastLength;
                separator = new RegExp(separator.source, flags + 'g');
                string += ''; // Type-convert
                if (!compliantExecNpcg) {
                    // Doesn't need flags gy, but they don't hurt
                    separator2 = new RegExp('^' + separator.source + '$(?!\\s)', flags);
                }
                /* Values for `limit`, per the spec:
                 * If undefined: 4294967295 // Math.pow(2, 32) - 1
                 * If 0, Infinity, or NaN: 0
                 * If positive number: limit = Math.floor(limit); if (limit > 4294967295) limit -= 4294967296;
                 * If negative number: 4294967296 - Math.floor(Math.abs(limit))
                 * If other: Type-convert, then use the above rules
                 */
                limit = limit === void 0 ?
                    -1 >>> 0 : // Math.pow(2, 32) - 1
                    ToUint32(limit);
                while (match = separator.exec(string)) {
                    // `separator.lastIndex` is not reliable cross-browser
                    lastIndex = match.index + match[0].length;
                    if (lastIndex > lastLastIndex) {
                        output.push(string.slice(lastLastIndex, match.index));
                        // Fix browsers whose `exec` methods don't consistently return `undefined` for
                        // nonparticipating capturing groups
                        if (!compliantExecNpcg && match.length > 1) {
                            match[0].replace(separator2, function () {
                                for (var i = 1; i < arguments.length - 2; i++) {
                                    if (arguments[i] === void 0) {
                                        match[i] = void 0;
                                    }
                                }
                            });
                        }
                        if (match.length > 1 && match.index < string.length) {
                            ArrayPrototype.push.apply(output, match.slice(1));
                        }
                        lastLength = match[0].length;
                        lastLastIndex = lastIndex;
                        if (output.length >= limit) {
                            break;
                        }
                    }
                    if (separator.lastIndex === match.index) {
                        separator.lastIndex++; // Avoid an infinite loop
                    }
                }
                if (lastLastIndex === string.length) {
                    if (lastLength || !separator.test('')) {
                        output.push('');
                    }
                } else {
                    output.push(string.slice(lastLastIndex));
                }
                return output.length > limit ? output.slice(0, limit) : output;
            };
        }());
    
    // [bugfix, chrome]
    // If separator is undefined, then the result array contains just one String,
    // which is the this value (converted to a String). If limit is not undefined,
    // then the output array is truncated so that it contains no more than limit
    // elements.
    // "0".split(undefined, 0) -> []
    } else if ('0'.split(void 0, 0).length) {
        StringPrototype.split = function split(separator, limit) {
            if (separator === void 0 && limit === 0) { return []; }
            return string_split.call(this, separator, limit);
        };
    }
    
    // ECMA-262, 3rd B.2.3
    // Not an ECMAScript standard, although ECMAScript 3rd Edition has a
    // non-normative section suggesting uniform semantics and it should be
    // normalized across all browsers
    // [bugfix, IE lt 9] IE < 9 substr() with negative value not working in IE
    var string_substr = StringPrototype.substr;
    var hasNegativeSubstrBug = ''.substr && '0b'.substr(-1) !== 'b';
    defineProperties(StringPrototype, {
        substr: function substr(start, length) {
            return string_substr.call(
                this,
                start < 0 ? ((start = this.length + start) < 0 ? 0 : start) : start,
                length
            );
        }
    }, hasNegativeSubstrBug);
    
    },{}],16:[function(require,module,exports){
    'use strict';
    
    module.exports = [
      // streaming transports
      require('./transport/websocket')
    , require('./transport/xhr-streaming')
    , require('./transport/xdr-streaming')
    , require('./transport/eventsource')
    , require('./transport/lib/iframe-wrap')(require('./transport/eventsource'))
    
      // polling transports
    , require('./transport/htmlfile')
    , require('./transport/lib/iframe-wrap')(require('./transport/htmlfile'))
    , require('./transport/xhr-polling')
    , require('./transport/xdr-polling')
    , require('./transport/lib/iframe-wrap')(require('./transport/xhr-polling'))
    , require('./transport/jsonp-polling')
    ];
    
    },{"./transport/eventsource":20,"./transport/htmlfile":21,"./transport/jsonp-polling":23,"./transport/lib/iframe-wrap":26,"./transport/websocket":38,"./transport/xdr-polling":39,"./transport/xdr-streaming":40,"./transport/xhr-polling":41,"./transport/xhr-streaming":42}],17:[function(require,module,exports){
    (function (process,global){
    'use strict';
    
    var EventEmitter = require('events').EventEmitter
      , inherits = require('inherits')
      , utils = require('../../utils/event')
      , urlUtils = require('../../utils/url')
      , XHR = global.XMLHttpRequest
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:browser:xhr');
    }
    
    function AbstractXHRObject(method, url, payload, opts) {
      debug(method, url);
      var self = this;
      EventEmitter.call(this);
    
      setTimeout(function () {
        self._start(method, url, payload, opts);
      }, 0);
    }
    
    inherits(AbstractXHRObject, EventEmitter);
    
    AbstractXHRObject.prototype._start = function(method, url, payload, opts) {
      var self = this;
    
      try {
        this.xhr = new XHR();
      } catch (x) {
        // intentionally empty
      }
    
      if (!this.xhr) {
        debug('no xhr');
        this.emit('finish', 0, 'no xhr support');
        this._cleanup();
        return;
      }
    
      // several browsers cache POSTs
      url = urlUtils.addQuery(url, 't=' + (+new Date()));
    
      // Explorer tends to keep connection open, even after the
      // tab gets closed: http://bugs.jquery.com/ticket/5280
      this.unloadRef = utils.unloadAdd(function() {
        debug('unload cleanup');
        self._cleanup(true);
      });
      try {
        this.xhr.open(method, url, true);
        if (this.timeout && 'timeout' in this.xhr) {
          this.xhr.timeout = this.timeout;
          this.xhr.ontimeout = function() {
            debug('xhr timeout');
            self.emit('finish', 0, '');
            self._cleanup(false);
          };
        }
      } catch (e) {
        debug('exception', e);
        // IE raises an exception on wrong port.
        this.emit('finish', 0, '');
        this._cleanup(false);
        return;
      }
    
      if ((!opts || !opts.noCredentials) && AbstractXHRObject.supportsCORS) {
        debug('withCredentials');
        // Mozilla docs says https://developer.mozilla.org/en/XMLHttpRequest :
        // "This never affects same-site requests."
    
        this.xhr.withCredentials = true;
      }
      if (opts && opts.headers) {
        for (var key in opts.headers) {
          this.xhr.setRequestHeader(key, opts.headers[key]);
        }
      }
    
      this.xhr.onreadystatechange = function() {
        if (self.xhr) {
          var x = self.xhr;
          var text, status;
          debug('readyState', x.readyState);
          switch (x.readyState) {
          case 3:
            // IE doesn't like peeking into responseText or status
            // on Microsoft.XMLHTTP and readystate=3
            try {
              status = x.status;
              text = x.responseText;
            } catch (e) {
              // intentionally empty
            }
            debug('status', status);
            // IE returns 1223 for 204: http://bugs.jquery.com/ticket/1450
            if (status === 1223) {
              status = 204;
            }
    
            // IE does return readystate == 3 for 404 answers.
            if (status === 200 && text && text.length > 0) {
              debug('chunk');
              self.emit('chunk', status, text);
            }
            break;
          case 4:
            status = x.status;
            debug('status', status);
            // IE returns 1223 for 204: http://bugs.jquery.com/ticket/1450
            if (status === 1223) {
              status = 204;
            }
            // IE returns this for a bad port
            // http://msdn.microsoft.com/en-us/library/windows/desktop/aa383770(v=vs.85).aspx
            if (status === 12005 || status === 12029) {
              status = 0;
            }
    
            debug('finish', status, x.responseText);
            self.emit('finish', status, x.responseText);
            self._cleanup(false);
            break;
          }
        }
      };
    
      try {
        self.xhr.send(payload);
      } catch (e) {
        self.emit('finish', 0, '');
        self._cleanup(false);
      }
    };
    
    AbstractXHRObject.prototype._cleanup = function(abort) {
      debug('cleanup');
      if (!this.xhr) {
        return;
      }
      this.removeAllListeners();
      utils.unloadDel(this.unloadRef);
    
      // IE needs this field to be a function
      this.xhr.onreadystatechange = function() {};
      if (this.xhr.ontimeout) {
        this.xhr.ontimeout = null;
      }
    
      if (abort) {
        try {
          this.xhr.abort();
        } catch (x) {
          // intentionally empty
        }
      }
      this.unloadRef = this.xhr = null;
    };
    
    AbstractXHRObject.prototype.close = function() {
      debug('close');
      this._cleanup(true);
    };
    
    AbstractXHRObject.enabled = !!XHR;
    // override XMLHttpRequest for IE6/7
    // obfuscate to avoid firewalls
    var axo = ['Active'].concat('Object').join('X');
    if (!AbstractXHRObject.enabled && (axo in global)) {
      debug('overriding xmlhttprequest');
      XHR = function() {
        try {
          return new global[axo]('Microsoft.XMLHTTP');
        } catch (e) {
          return null;
        }
      };
      AbstractXHRObject.enabled = !!new XHR();
    }
    
    var cors = false;
    try {
      cors = 'withCredentials' in new XHR();
    } catch (ignored) {
      // intentionally empty
    }
    
    AbstractXHRObject.supportsCORS = cors;
    
    module.exports = AbstractXHRObject;
    
    }).call(this,{ env: {} },typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"../../utils/event":46,"../../utils/url":52,"debug":54,"events":3,"inherits":56}],18:[function(require,module,exports){
    (function (global){
    module.exports = global.EventSource;
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{}],19:[function(require,module,exports){
    (function (global){
    'use strict';
    
    var Driver = global.WebSocket || global.MozWebSocket;
    if (Driver) {
        module.exports = function WebSocketBrowserDriver(url) {
            return new Driver(url);
        };
    } else {
        module.exports = undefined;
    }
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{}],20:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , AjaxBasedTransport = require('./lib/ajax-based')
      , EventSourceReceiver = require('./receiver/eventsource')
      , XHRCorsObject = require('./sender/xhr-cors')
      , EventSourceDriver = require('eventsource')
      ;
    
    function EventSourceTransport(transUrl) {
      if (!EventSourceTransport.enabled()) {
        throw new Error('Transport created when disabled');
      }
    
      AjaxBasedTransport.call(this, transUrl, '/eventsource', EventSourceReceiver, XHRCorsObject);
    }
    
    inherits(EventSourceTransport, AjaxBasedTransport);
    
    EventSourceTransport.enabled = function() {
      return !!EventSourceDriver;
    };
    
    EventSourceTransport.transportName = 'eventsource';
    EventSourceTransport.roundTrips = 2;
    
    module.exports = EventSourceTransport;
    
    },{"./lib/ajax-based":24,"./receiver/eventsource":29,"./sender/xhr-cors":35,"eventsource":18,"inherits":56}],21:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , HtmlfileReceiver = require('./receiver/htmlfile')
      , XHRLocalObject = require('./sender/xhr-local')
      , AjaxBasedTransport = require('./lib/ajax-based')
      ;
    
    function HtmlFileTransport(transUrl) {
      if (!HtmlfileReceiver.enabled) {
        throw new Error('Transport created when disabled');
      }
      AjaxBasedTransport.call(this, transUrl, '/htmlfile', HtmlfileReceiver, XHRLocalObject);
    }
    
    inherits(HtmlFileTransport, AjaxBasedTransport);
    
    HtmlFileTransport.enabled = function(info) {
      return HtmlfileReceiver.enabled && info.sameOrigin;
    };
    
    HtmlFileTransport.transportName = 'htmlfile';
    HtmlFileTransport.roundTrips = 2;
    
    module.exports = HtmlFileTransport;
    
    },{"./lib/ajax-based":24,"./receiver/htmlfile":30,"./sender/xhr-local":37,"inherits":56}],22:[function(require,module,exports){
    (function (process){
    'use strict';
    
    // Few cool transports do work only for same-origin. In order to make
    // them work cross-domain we shall use iframe, served from the
    // remote domain. New browsers have capabilities to communicate with
    // cross domain iframe using postMessage(). In IE it was implemented
    // from IE 8+, but of course, IE got some details wrong:
    //    http://msdn.microsoft.com/en-us/library/cc197015(v=VS.85).aspx
    //    http://stevesouders.com/misc/test-postmessage.php
    
    var inherits = require('inherits')
      , JSON3 = require('json3')
      , EventEmitter = require('events').EventEmitter
      , version = require('../version')
      , urlUtils = require('../utils/url')
      , iframeUtils = require('../utils/iframe')
      , eventUtils = require('../utils/event')
      , random = require('../utils/random')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:transport:iframe');
    }
    
    function IframeTransport(transport, transUrl, baseUrl) {
      if (!IframeTransport.enabled()) {
        throw new Error('Transport created when disabled');
      }
      EventEmitter.call(this);
    
      var self = this;
      this.origin = urlUtils.getOrigin(baseUrl);
      this.baseUrl = baseUrl;
      this.transUrl = transUrl;
      this.transport = transport;
      this.windowId = random.string(8);
    
      var iframeUrl = urlUtils.addPath(baseUrl, '/iframe.html') + '#' + this.windowId;
      debug(transport, transUrl, iframeUrl);
    
      this.iframeObj = iframeUtils.createIframe(iframeUrl, function(r) {
        debug('err callback');
        self.emit('close', 1006, 'Unable to load an iframe (' + r + ')');
        self.close();
      });
    
      this.onmessageCallback = this._message.bind(this);
      eventUtils.attachEvent('message', this.onmessageCallback);
    }
    
    inherits(IframeTransport, EventEmitter);
    
    IframeTransport.prototype.close = function() {
      debug('close');
      this.removeAllListeners();
      if (this.iframeObj) {
        eventUtils.detachEvent('message', this.onmessageCallback);
        try {
          // When the iframe is not loaded, IE raises an exception
          // on 'contentWindow'.
          this.postMessage('c');
        } catch (x) {
          // intentionally empty
        }
        this.iframeObj.cleanup();
        this.iframeObj = null;
        this.onmessageCallback = this.iframeObj = null;
      }
    };
    
    IframeTransport.prototype._message = function(e) {
      debug('message', e.data);
      if (!urlUtils.isOriginEqual(e.origin, this.origin)) {
        debug('not same origin', e.origin, this.origin);
        return;
      }
    
      var iframeMessage;
      try {
        iframeMessage = JSON3.parse(e.data);
      } catch (ignored) {
        debug('bad json', e.data);
        return;
      }
    
      if (iframeMessage.windowId !== this.windowId) {
        debug('mismatched window id', iframeMessage.windowId, this.windowId);
        return;
      }
    
      switch (iframeMessage.type) {
      case 's':
        this.iframeObj.loaded();
        // window global dependency
        this.postMessage('s', JSON3.stringify([
          version
        , this.transport
        , this.transUrl
        , this.baseUrl
        ]));
        break;
      case 't':
        this.emit('message', iframeMessage.data);
        break;
      case 'c':
        var cdata;
        try {
          cdata = JSON3.parse(iframeMessage.data);
        } catch (ignored) {
          debug('bad json', iframeMessage.data);
          return;
        }
        this.emit('close', cdata[0], cdata[1]);
        this.close();
        break;
      }
    };
    
    IframeTransport.prototype.postMessage = function(type, data) {
      debug('postMessage', type, data);
      this.iframeObj.post(JSON3.stringify({
        windowId: this.windowId
      , type: type
      , data: data || ''
      }), this.origin);
    };
    
    IframeTransport.prototype.send = function(message) {
      debug('send', message);
      this.postMessage('m', message);
    };
    
    IframeTransport.enabled = function() {
      return iframeUtils.iframeEnabled;
    };
    
    IframeTransport.transportName = 'iframe';
    IframeTransport.roundTrips = 2;
    
    module.exports = IframeTransport;
    
    }).call(this,{ env: {} })
    
    },{"../utils/event":46,"../utils/iframe":47,"../utils/random":50,"../utils/url":52,"../version":53,"debug":54,"events":3,"inherits":56,"json3":57}],23:[function(require,module,exports){
    (function (global){
    'use strict';
    
    // The simplest and most robust transport, using the well-know cross
    // domain hack - JSONP. This transport is quite inefficient - one
    // message could use up to one http request. But at least it works almost
    // everywhere.
    // Known limitations:
    //   o you will get a spinning cursor
    //   o for Konqueror a dumb timer is needed to detect errors
    
    var inherits = require('inherits')
      , SenderReceiver = require('./lib/sender-receiver')
      , JsonpReceiver = require('./receiver/jsonp')
      , jsonpSender = require('./sender/jsonp')
      ;
    
    function JsonPTransport(transUrl) {
      if (!JsonPTransport.enabled()) {
        throw new Error('Transport created when disabled');
      }
      SenderReceiver.call(this, transUrl, '/jsonp', jsonpSender, JsonpReceiver);
    }
    
    inherits(JsonPTransport, SenderReceiver);
    
    JsonPTransport.enabled = function() {
      return !!global.document;
    };
    
    JsonPTransport.transportName = 'jsonp-polling';
    JsonPTransport.roundTrips = 1;
    JsonPTransport.needBody = true;
    
    module.exports = JsonPTransport;
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"./lib/sender-receiver":28,"./receiver/jsonp":31,"./sender/jsonp":33,"inherits":56}],24:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var inherits = require('inherits')
      , urlUtils = require('../../utils/url')
      , SenderReceiver = require('./sender-receiver')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:ajax-based');
    }
    
    function createAjaxSender(AjaxObject) {
      return function(url, payload, callback) {
        debug('create ajax sender', url, payload);
        var opt = {};
        if (typeof payload === 'string') {
          opt.headers = {'Content-type': 'text/plain'};
        }
        var ajaxUrl = urlUtils.addPath(url, '/xhr_send');
        var xo = new AjaxObject('POST', ajaxUrl, payload, opt);
        xo.once('finish', function(status) {
          debug('finish', status);
          xo = null;
    
          if (status !== 200 && status !== 204) {
            return callback(new Error('http status ' + status));
          }
          callback();
        });
        return function() {
          debug('abort');
          xo.close();
          xo = null;
    
          var err = new Error('Aborted');
          err.code = 1000;
          callback(err);
        };
      };
    }
    
    function AjaxBasedTransport(transUrl, urlSuffix, Receiver, AjaxObject) {
      SenderReceiver.call(this, transUrl, urlSuffix, createAjaxSender(AjaxObject), Receiver, AjaxObject);
    }
    
    inherits(AjaxBasedTransport, SenderReceiver);
    
    module.exports = AjaxBasedTransport;
    
    }).call(this,{ env: {} })
    
    },{"../../utils/url":52,"./sender-receiver":28,"debug":54,"inherits":56}],25:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var inherits = require('inherits')
      , EventEmitter = require('events').EventEmitter
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:buffered-sender');
    }
    
    function BufferedSender(url, sender) {
      debug(url);
      EventEmitter.call(this);
      this.sendBuffer = [];
      this.sender = sender;
      this.url = url;
    }
    
    inherits(BufferedSender, EventEmitter);
    
    BufferedSender.prototype.send = function(message) {
      debug('send', message);
      this.sendBuffer.push(message);
      if (!this.sendStop) {
        this.sendSchedule();
      }
    };
    
    // For polling transports in a situation when in the message callback,
    // new message is being send. If the sending connection was started
    // before receiving one, it is possible to saturate the network and
    // timeout due to the lack of receiving socket. To avoid that we delay
    // sending messages by some small time, in order to let receiving
    // connection be started beforehand. This is only a halfmeasure and
    // does not fix the big problem, but it does make the tests go more
    // stable on slow networks.
    BufferedSender.prototype.sendScheduleWait = function() {
      debug('sendScheduleWait');
      var self = this;
      var tref;
      this.sendStop = function() {
        debug('sendStop');
        self.sendStop = null;
        clearTimeout(tref);
      };
      tref = setTimeout(function() {
        debug('timeout');
        self.sendStop = null;
        self.sendSchedule();
      }, 25);
    };
    
    BufferedSender.prototype.sendSchedule = function() {
      debug('sendSchedule', this.sendBuffer.length);
      var self = this;
      if (this.sendBuffer.length > 0) {
        var payload = '[' + this.sendBuffer.join(',') + ']';
        this.sendStop = this.sender(this.url, payload, function(err) {
          self.sendStop = null;
          if (err) {
            debug('error', err);
            self.emit('close', err.code || 1006, 'Sending error: ' + err);
            self.close();
          } else {
            self.sendScheduleWait();
          }
        });
        this.sendBuffer = [];
      }
    };
    
    BufferedSender.prototype._cleanup = function() {
      debug('_cleanup');
      this.removeAllListeners();
    };
    
    BufferedSender.prototype.close = function() {
      debug('close');
      this._cleanup();
      if (this.sendStop) {
        this.sendStop();
        this.sendStop = null;
      }
    };
    
    module.exports = BufferedSender;
    
    }).call(this,{ env: {} })
    
    },{"debug":54,"events":3,"inherits":56}],26:[function(require,module,exports){
    (function (global){
    'use strict';
    
    var inherits = require('inherits')
      , IframeTransport = require('../iframe')
      , objectUtils = require('../../utils/object')
      ;
    
    module.exports = function(transport) {
    
      function IframeWrapTransport(transUrl, baseUrl) {
        IframeTransport.call(this, transport.transportName, transUrl, baseUrl);
      }
    
      inherits(IframeWrapTransport, IframeTransport);
    
      IframeWrapTransport.enabled = function(url, info) {
        if (!global.document) {
          return false;
        }
    
        var iframeInfo = objectUtils.extend({}, info);
        iframeInfo.sameOrigin = true;
        return transport.enabled(iframeInfo) && IframeTransport.enabled();
      };
    
      IframeWrapTransport.transportName = 'iframe-' + transport.transportName;
      IframeWrapTransport.needBody = true;
      IframeWrapTransport.roundTrips = IframeTransport.roundTrips + transport.roundTrips - 1; // html, javascript (2) + transport - no CORS (1)
    
      IframeWrapTransport.facadeTransport = transport;
    
      return IframeWrapTransport;
    };
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"../../utils/object":49,"../iframe":22,"inherits":56}],27:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var inherits = require('inherits')
      , EventEmitter = require('events').EventEmitter
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:polling');
    }
    
    function Polling(Receiver, receiveUrl, AjaxObject) {
      debug(receiveUrl);
      EventEmitter.call(this);
      this.Receiver = Receiver;
      this.receiveUrl = receiveUrl;
      this.AjaxObject = AjaxObject;
      this._scheduleReceiver();
    }
    
    inherits(Polling, EventEmitter);
    
    Polling.prototype._scheduleReceiver = function() {
      debug('_scheduleReceiver');
      var self = this;
      var poll = this.poll = new this.Receiver(this.receiveUrl, this.AjaxObject);
    
      poll.on('message', function(msg) {
        debug('message', msg);
        self.emit('message', msg);
      });
    
      poll.once('close', function(code, reason) {
        debug('close', code, reason, self.pollIsClosing);
        self.poll = poll = null;
    
        if (!self.pollIsClosing) {
          if (reason === 'network') {
            self._scheduleReceiver();
          } else {
            self.emit('close', code || 1006, reason);
            self.removeAllListeners();
          }
        }
      });
    };
    
    Polling.prototype.abort = function() {
      debug('abort');
      this.removeAllListeners();
      this.pollIsClosing = true;
      if (this.poll) {
        this.poll.abort();
      }
    };
    
    module.exports = Polling;
    
    }).call(this,{ env: {} })
    
    },{"debug":54,"events":3,"inherits":56}],28:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var inherits = require('inherits')
      , urlUtils = require('../../utils/url')
      , BufferedSender = require('./buffered-sender')
      , Polling = require('./polling')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:sender-receiver');
    }
    
    function SenderReceiver(transUrl, urlSuffix, senderFunc, Receiver, AjaxObject) {
      var pollUrl = urlUtils.addPath(transUrl, urlSuffix);
      debug(pollUrl);
      var self = this;
      BufferedSender.call(this, transUrl, senderFunc);
    
      this.poll = new Polling(Receiver, pollUrl, AjaxObject);
      this.poll.on('message', function(msg) {
        debug('poll message', msg);
        self.emit('message', msg);
      });
      this.poll.once('close', function(code, reason) {
        debug('poll close', code, reason);
        self.poll = null;
        self.emit('close', code, reason);
        self.close();
      });
    }
    
    inherits(SenderReceiver, BufferedSender);
    
    SenderReceiver.prototype.close = function() {
      BufferedSender.prototype.close.call(this);
      debug('close');
      this.removeAllListeners();
      if (this.poll) {
        this.poll.abort();
        this.poll = null;
      }
    };
    
    module.exports = SenderReceiver;
    
    }).call(this,{ env: {} })
    
    },{"../../utils/url":52,"./buffered-sender":25,"./polling":27,"debug":54,"inherits":56}],29:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var inherits = require('inherits')
      , EventEmitter = require('events').EventEmitter
      , EventSourceDriver = require('eventsource')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:receiver:eventsource');
    }
    
    function EventSourceReceiver(url) {
      debug(url);
      EventEmitter.call(this);
    
      var self = this;
      var es = this.es = new EventSourceDriver(url);
      es.onmessage = function(e) {
        debug('message', e.data);
        self.emit('message', decodeURI(e.data));
      };
      es.onerror = function(e) {
        debug('error', es.readyState, e);
        // ES on reconnection has readyState = 0 or 1.
        // on network error it's CLOSED = 2
        var reason = (es.readyState !== 2 ? 'network' : 'permanent');
        self._cleanup();
        self._close(reason);
      };
    }
    
    inherits(EventSourceReceiver, EventEmitter);
    
    EventSourceReceiver.prototype.abort = function() {
      debug('abort');
      this._cleanup();
      this._close('user');
    };
    
    EventSourceReceiver.prototype._cleanup = function() {
      debug('cleanup');
      var es = this.es;
      if (es) {
        es.onmessage = es.onerror = null;
        es.close();
        this.es = null;
      }
    };
    
    EventSourceReceiver.prototype._close = function(reason) {
      debug('close', reason);
      var self = this;
      // Safari and chrome < 15 crash if we close window before
      // waiting for ES cleanup. See:
      // https://code.google.com/p/chromium/issues/detail?id=89155
      setTimeout(function() {
        self.emit('close', null, reason);
        self.removeAllListeners();
      }, 200);
    };
    
    module.exports = EventSourceReceiver;
    
    }).call(this,{ env: {} })
    
    },{"debug":54,"events":3,"eventsource":18,"inherits":56}],30:[function(require,module,exports){
    (function (process,global){
    'use strict';
    
    var inherits = require('inherits')
      , iframeUtils = require('../../utils/iframe')
      , urlUtils = require('../../utils/url')
      , EventEmitter = require('events').EventEmitter
      , random = require('../../utils/random')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:receiver:htmlfile');
    }
    
    function HtmlfileReceiver(url) {
      debug(url);
      EventEmitter.call(this);
      var self = this;
      iframeUtils.polluteGlobalNamespace();
    
      this.id = 'a' + random.string(6);
      url = urlUtils.addQuery(url, 'c=' + decodeURIComponent(iframeUtils.WPrefix + '.' + this.id));
    
      debug('using htmlfile', HtmlfileReceiver.htmlfileEnabled);
      var constructFunc = HtmlfileReceiver.htmlfileEnabled ?
          iframeUtils.createHtmlfile : iframeUtils.createIframe;
    
      global[iframeUtils.WPrefix][this.id] = {
        start: function() {
          debug('start');
          self.iframeObj.loaded();
        }
      , message: function(data) {
          debug('message', data);
          self.emit('message', data);
        }
      , stop: function() {
          debug('stop');
          self._cleanup();
          self._close('network');
        }
      };
      this.iframeObj = constructFunc(url, function() {
        debug('callback');
        self._cleanup();
        self._close('permanent');
      });
    }
    
    inherits(HtmlfileReceiver, EventEmitter);
    
    HtmlfileReceiver.prototype.abort = function() {
      debug('abort');
      this._cleanup();
      this._close('user');
    };
    
    HtmlfileReceiver.prototype._cleanup = function() {
      debug('_cleanup');
      if (this.iframeObj) {
        this.iframeObj.cleanup();
        this.iframeObj = null;
      }
      delete global[iframeUtils.WPrefix][this.id];
    };
    
    HtmlfileReceiver.prototype._close = function(reason) {
      debug('_close', reason);
      this.emit('close', null, reason);
      this.removeAllListeners();
    };
    
    HtmlfileReceiver.htmlfileEnabled = false;
    
    // obfuscate to avoid firewalls
    var axo = ['Active'].concat('Object').join('X');
    if (axo in global) {
      try {
        HtmlfileReceiver.htmlfileEnabled = !!new global[axo]('htmlfile');
      } catch (x) {
        // intentionally empty
      }
    }
    
    HtmlfileReceiver.enabled = HtmlfileReceiver.htmlfileEnabled || iframeUtils.iframeEnabled;
    
    module.exports = HtmlfileReceiver;
    
    }).call(this,{ env: {} },typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"../../utils/iframe":47,"../../utils/random":50,"../../utils/url":52,"debug":54,"events":3,"inherits":56}],31:[function(require,module,exports){
    (function (process,global){
    'use strict';
    
    var utils = require('../../utils/iframe')
      , random = require('../../utils/random')
      , browser = require('../../utils/browser')
      , urlUtils = require('../../utils/url')
      , inherits = require('inherits')
      , EventEmitter = require('events').EventEmitter
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:receiver:jsonp');
    }
    
    function JsonpReceiver(url) {
      debug(url);
      var self = this;
      EventEmitter.call(this);
    
      utils.polluteGlobalNamespace();
    
      this.id = 'a' + random.string(6);
      var urlWithId = urlUtils.addQuery(url, 'c=' + encodeURIComponent(utils.WPrefix + '.' + this.id));
    
      global[utils.WPrefix][this.id] = this._callback.bind(this);
      this._createScript(urlWithId);
    
      // Fallback mostly for Konqueror - stupid timer, 35 seconds shall be plenty.
      this.timeoutId = setTimeout(function() {
        debug('timeout');
        self._abort(new Error('JSONP script loaded abnormally (timeout)'));
      }, JsonpReceiver.timeout);
    }
    
    inherits(JsonpReceiver, EventEmitter);
    
    JsonpReceiver.prototype.abort = function() {
      debug('abort');
      if (global[utils.WPrefix][this.id]) {
        var err = new Error('JSONP user aborted read');
        err.code = 1000;
        this._abort(err);
      }
    };
    
    JsonpReceiver.timeout = 35000;
    JsonpReceiver.scriptErrorTimeout = 1000;
    
    JsonpReceiver.prototype._callback = function(data) {
      debug('_callback', data);
      this._cleanup();
    
      if (this.aborting) {
        return;
      }
    
      if (data) {
        debug('message', data);
        this.emit('message', data);
      }
      this.emit('close', null, 'network');
      this.removeAllListeners();
    };
    
    JsonpReceiver.prototype._abort = function(err) {
      debug('_abort', err);
      this._cleanup();
      this.aborting = true;
      this.emit('close', err.code, err.message);
      this.removeAllListeners();
    };
    
    JsonpReceiver.prototype._cleanup = function() {
      debug('_cleanup');
      clearTimeout(this.timeoutId);
      if (this.script2) {
        this.script2.parentNode.removeChild(this.script2);
        this.script2 = null;
      }
      if (this.script) {
        var script = this.script;
        // Unfortunately, you can't really abort script loading of
        // the script.
        script.parentNode.removeChild(script);
        script.onreadystatechange = script.onerror =
            script.onload = script.onclick = null;
        this.script = null;
      }
      delete global[utils.WPrefix][this.id];
    };
    
    JsonpReceiver.prototype._scriptError = function() {
      debug('_scriptError');
      var self = this;
      if (this.errorTimer) {
        return;
      }
    
      this.errorTimer = setTimeout(function() {
        if (!self.loadedOkay) {
          self._abort(new Error('JSONP script loaded abnormally (onerror)'));
        }
      }, JsonpReceiver.scriptErrorTimeout);
    };
    
    JsonpReceiver.prototype._createScript = function(url) {
      debug('_createScript', url);
      var self = this;
      var script = this.script = global.document.createElement('script');
      var script2;  // Opera synchronous load trick.
    
      script.id = 'a' + random.string(8);
      script.src = url;
      script.type = 'text/javascript';
      script.charset = 'UTF-8';
      script.onerror = this._scriptError.bind(this);
      script.onload = function() {
        debug('onload');
        self._abort(new Error('JSONP script loaded abnormally (onload)'));
      };
    
      // IE9 fires 'error' event after onreadystatechange or before, in random order.
      // Use loadedOkay to determine if actually errored
      script.onreadystatechange = function() {
        debug('onreadystatechange', script.readyState);
        if (/loaded|closed/.test(script.readyState)) {
          if (script && script.htmlFor && script.onclick) {
            self.loadedOkay = true;
            try {
              // In IE, actually execute the script.
              script.onclick();
            } catch (x) {
              // intentionally empty
            }
          }
          if (script) {
            self._abort(new Error('JSONP script loaded abnormally (onreadystatechange)'));
          }
        }
      };
      // IE: event/htmlFor/onclick trick.
      // One can't rely on proper order for onreadystatechange. In order to
      // make sure, set a 'htmlFor' and 'event' properties, so that
      // script code will be installed as 'onclick' handler for the
      // script object. Later, onreadystatechange, manually execute this
      // code. FF and Chrome doesn't work with 'event' and 'htmlFor'
      // set. For reference see:
      //   http://jaubourg.net/2010/07/loading-script-as-onclick-handler-of.html
      // Also, read on that about script ordering:
      //   http://wiki.whatwg.org/wiki/Dynamic_Script_Execution_Order
      if (typeof script.async === 'undefined' && global.document.attachEvent) {
        // According to mozilla docs, in recent browsers script.async defaults
        // to 'true', so we may use it to detect a good browser:
        // https://developer.mozilla.org/en/HTML/Element/script
        if (!browser.isOpera()) {
          // Naively assume we're in IE
          try {
            script.htmlFor = script.id;
            script.event = 'onclick';
          } catch (x) {
            // intentionally empty
          }
          script.async = true;
        } else {
          // Opera, second sync script hack
          script2 = this.script2 = global.document.createElement('script');
          script2.text = "try{var a = document.getElementById('" + script.id + "'); if(a)a.onerror();}catch(x){};";
          script.async = script2.async = false;
        }
      }
      if (typeof script.async !== 'undefined') {
        script.async = true;
      }
    
      var head = global.document.getElementsByTagName('head')[0];
      head.insertBefore(script, head.firstChild);
      if (script2) {
        head.insertBefore(script2, head.firstChild);
      }
    };
    
    module.exports = JsonpReceiver;
    
    }).call(this,{ env: {} },typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"../../utils/browser":44,"../../utils/iframe":47,"../../utils/random":50,"../../utils/url":52,"debug":54,"events":3,"inherits":56}],32:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var inherits = require('inherits')
      , EventEmitter = require('events').EventEmitter
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:receiver:xhr');
    }
    
    function XhrReceiver(url, AjaxObject) {
      debug(url);
      EventEmitter.call(this);
      var self = this;
    
      this.bufferPosition = 0;
    
      this.xo = new AjaxObject('POST', url, null);
      this.xo.on('chunk', this._chunkHandler.bind(this));
      this.xo.once('finish', function(status, text) {
        debug('finish', status, text);
        self._chunkHandler(status, text);
        self.xo = null;
        var reason = status === 200 ? 'network' : 'permanent';
        debug('close', reason);
        self.emit('close', null, reason);
        self._cleanup();
      });
    }
    
    inherits(XhrReceiver, EventEmitter);
    
    XhrReceiver.prototype._chunkHandler = function(status, text) {
      debug('_chunkHandler', status);
      if (status !== 200 || !text) {
        return;
      }
    
      for (var idx = -1; ; this.bufferPosition += idx + 1) {
        var buf = text.slice(this.bufferPosition);
        idx = buf.indexOf('\n');
        if (idx === -1) {
          break;
        }
        var msg = buf.slice(0, idx);
        if (msg) {
          debug('message', msg);
          this.emit('message', msg);
        }
      }
    };
    
    XhrReceiver.prototype._cleanup = function() {
      debug('_cleanup');
      this.removeAllListeners();
    };
    
    XhrReceiver.prototype.abort = function() {
      debug('abort');
      if (this.xo) {
        this.xo.close();
        debug('close');
        this.emit('close', null, 'user');
        this.xo = null;
      }
      this._cleanup();
    };
    
    module.exports = XhrReceiver;
    
    }).call(this,{ env: {} })
    
    },{"debug":54,"events":3,"inherits":56}],33:[function(require,module,exports){
    (function (process,global){
    'use strict';
    
    var random = require('../../utils/random')
      , urlUtils = require('../../utils/url')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:sender:jsonp');
    }
    
    var form, area;
    
    function createIframe(id) {
      debug('createIframe', id);
      try {
        // ie6 dynamic iframes with target="" support (thanks Chris Lambacher)
        return global.document.createElement('<iframe name="' + id + '">');
      } catch (x) {
        var iframe = global.document.createElement('iframe');
        iframe.name = id;
        return iframe;
      }
    }
    
    function createForm() {
      debug('createForm');
      form = global.document.createElement('form');
      form.style.display = 'none';
      form.style.position = 'absolute';
      form.method = 'POST';
      form.enctype = 'application/x-www-form-urlencoded';
      form.acceptCharset = 'UTF-8';
    
      area = global.document.createElement('textarea');
      area.name = 'd';
      form.appendChild(area);
    
      global.document.body.appendChild(form);
    }
    
    module.exports = function(url, payload, callback) {
      debug(url, payload);
      if (!form) {
        createForm();
      }
      var id = 'a' + random.string(8);
      form.target = id;
      form.action = urlUtils.addQuery(urlUtils.addPath(url, '/jsonp_send'), 'i=' + id);
    
      var iframe = createIframe(id);
      iframe.id = id;
      iframe.style.display = 'none';
      form.appendChild(iframe);
    
      try {
        area.value = payload;
      } catch (e) {
        // seriously broken browsers get here
      }
      form.submit();
    
      var completed = function(err) {
        debug('completed', id, err);
        if (!iframe.onerror) {
          return;
        }
        iframe.onreadystatechange = iframe.onerror = iframe.onload = null;
        // Opera mini doesn't like if we GC iframe
        // immediately, thus this timeout.
        setTimeout(function() {
          debug('cleaning up', id);
          iframe.parentNode.removeChild(iframe);
          iframe = null;
        }, 500);
        area.value = '';
        // It is not possible to detect if the iframe succeeded or
        // failed to submit our form.
        callback(err);
      };
      iframe.onerror = function() {
        debug('onerror', id);
        completed();
      };
      iframe.onload = function() {
        debug('onload', id);
        completed();
      };
      iframe.onreadystatechange = function(e) {
        debug('onreadystatechange', id, iframe.readyState, e);
        if (iframe.readyState === 'complete') {
          completed();
        }
      };
      return function() {
        debug('aborted', id);
        completed(new Error('Aborted'));
      };
    };
    
    }).call(this,{ env: {} },typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"../../utils/random":50,"../../utils/url":52,"debug":54}],34:[function(require,module,exports){
    (function (process,global){
    'use strict';
    
    var EventEmitter = require('events').EventEmitter
      , inherits = require('inherits')
      , eventUtils = require('../../utils/event')
      , browser = require('../../utils/browser')
      , urlUtils = require('../../utils/url')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:sender:xdr');
    }
    
    // References:
    //   http://ajaxian.com/archives/100-line-ajax-wrapper
    //   http://msdn.microsoft.com/en-us/library/cc288060(v=VS.85).aspx
    
    function XDRObject(method, url, payload) {
      debug(method, url);
      var self = this;
      EventEmitter.call(this);
    
      setTimeout(function() {
        self._start(method, url, payload);
      }, 0);
    }
    
    inherits(XDRObject, EventEmitter);
    
    XDRObject.prototype._start = function(method, url, payload) {
      debug('_start');
      var self = this;
      var xdr = new global.XDomainRequest();
      // IE caches even POSTs
      url = urlUtils.addQuery(url, 't=' + (+new Date()));
    
      xdr.onerror = function() {
        debug('onerror');
        self._error();
      };
      xdr.ontimeout = function() {
        debug('ontimeout');
        self._error();
      };
      xdr.onprogress = function() {
        debug('progress', xdr.responseText);
        self.emit('chunk', 200, xdr.responseText);
      };
      xdr.onload = function() {
        debug('load');
        self.emit('finish', 200, xdr.responseText);
        self._cleanup(false);
      };
      this.xdr = xdr;
      this.unloadRef = eventUtils.unloadAdd(function() {
        self._cleanup(true);
      });
      try {
        // Fails with AccessDenied if port number is bogus
        this.xdr.open(method, url);
        if (this.timeout) {
          this.xdr.timeout = this.timeout;
        }
        this.xdr.send(payload);
      } catch (x) {
        this._error();
      }
    };
    
    XDRObject.prototype._error = function() {
      this.emit('finish', 0, '');
      this._cleanup(false);
    };
    
    XDRObject.prototype._cleanup = function(abort) {
      debug('cleanup', abort);
      if (!this.xdr) {
        return;
      }
      this.removeAllListeners();
      eventUtils.unloadDel(this.unloadRef);
    
      this.xdr.ontimeout = this.xdr.onerror = this.xdr.onprogress = this.xdr.onload = null;
      if (abort) {
        try {
          this.xdr.abort();
        } catch (x) {
          // intentionally empty
        }
      }
      this.unloadRef = this.xdr = null;
    };
    
    XDRObject.prototype.close = function() {
      debug('close');
      this._cleanup(true);
    };
    
    // IE 8/9 if the request target uses the same scheme - #79
    XDRObject.enabled = !!(global.XDomainRequest && browser.hasDomain());
    
    module.exports = XDRObject;
    
    }).call(this,{ env: {} },typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"../../utils/browser":44,"../../utils/event":46,"../../utils/url":52,"debug":54,"events":3,"inherits":56}],35:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , XhrDriver = require('../driver/xhr')
      ;
    
    function XHRCorsObject(method, url, payload, opts) {
      XhrDriver.call(this, method, url, payload, opts);
    }
    
    inherits(XHRCorsObject, XhrDriver);
    
    XHRCorsObject.enabled = XhrDriver.enabled && XhrDriver.supportsCORS;
    
    module.exports = XHRCorsObject;
    
    },{"../driver/xhr":17,"inherits":56}],36:[function(require,module,exports){
    'use strict';
    
    var EventEmitter = require('events').EventEmitter
      , inherits = require('inherits')
      ;
    
    function XHRFake(/* method, url, payload, opts */) {
      var self = this;
      EventEmitter.call(this);
    
      this.to = setTimeout(function() {
        self.emit('finish', 200, '{}');
      }, XHRFake.timeout);
    }
    
    inherits(XHRFake, EventEmitter);
    
    XHRFake.prototype.close = function() {
      clearTimeout(this.to);
    };
    
    XHRFake.timeout = 2000;
    
    module.exports = XHRFake;
    
    },{"events":3,"inherits":56}],37:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , XhrDriver = require('../driver/xhr')
      ;
    
    function XHRLocalObject(method, url, payload /*, opts */) {
      XhrDriver.call(this, method, url, payload, {
        noCredentials: true
      });
    }
    
    inherits(XHRLocalObject, XhrDriver);
    
    XHRLocalObject.enabled = XhrDriver.enabled;
    
    module.exports = XHRLocalObject;
    
    },{"../driver/xhr":17,"inherits":56}],38:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var utils = require('../utils/event')
      , urlUtils = require('../utils/url')
      , inherits = require('inherits')
      , EventEmitter = require('events').EventEmitter
      , WebsocketDriver = require('./driver/websocket')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:websocket');
    }
    
    function WebSocketTransport(transUrl, ignore, options) {
      if (!WebSocketTransport.enabled()) {
        throw new Error('Transport created when disabled');
      }
    
      EventEmitter.call(this);
      debug('constructor', transUrl);
    
      var self = this;
      var url = urlUtils.addPath(transUrl, '/websocket');
      if (url.slice(0, 5) === 'https') {
        url = 'wss' + url.slice(5);
      } else {
        url = 'ws' + url.slice(4);
      }
      this.url = url;
    
      this.ws = new WebsocketDriver(this.url, [], options);
      this.ws.onmessage = function(e) {
        debug('message event', e.data);
        self.emit('message', e.data);
      };
      // Firefox has an interesting bug. If a websocket connection is
      // created after onunload, it stays alive even when user
      // navigates away from the page. In such situation let's lie -
      // let's not open the ws connection at all. See:
      // https://github.com/sockjs/sockjs-client/issues/28
      // https://bugzilla.mozilla.org/show_bug.cgi?id=696085
      this.unloadRef = utils.unloadAdd(function() {
        debug('unload');
        self.ws.close();
      });
      this.ws.onclose = function(e) {
        debug('close event', e.code, e.reason);
        self.emit('close', e.code, e.reason);
        self._cleanup();
      };
      this.ws.onerror = function(e) {
        debug('error event', e);
        self.emit('close', 1006, 'WebSocket connection broken');
        self._cleanup();
      };
    }
    
    inherits(WebSocketTransport, EventEmitter);
    
    WebSocketTransport.prototype.send = function(data) {
      var msg = '[' + data + ']';
      debug('send', msg);
      this.ws.send(msg);
    };
    
    WebSocketTransport.prototype.close = function() {
      debug('close');
      var ws = this.ws;
      this._cleanup();
      if (ws) {
        ws.close();
      }
    };
    
    WebSocketTransport.prototype._cleanup = function() {
      debug('_cleanup');
      var ws = this.ws;
      if (ws) {
        ws.onmessage = ws.onclose = ws.onerror = null;
      }
      utils.unloadDel(this.unloadRef);
      this.unloadRef = this.ws = null;
      this.removeAllListeners();
    };
    
    WebSocketTransport.enabled = function() {
      debug('enabled');
      return !!WebsocketDriver;
    };
    WebSocketTransport.transportName = 'websocket';
    
    // In theory, ws should require 1 round trip. But in chrome, this is
    // not very stable over SSL. Most likely a ws connection requires a
    // separate SSL connection, in which case 2 round trips are an
    // absolute minumum.
    WebSocketTransport.roundTrips = 2;
    
    module.exports = WebSocketTransport;
    
    }).call(this,{ env: {} })
    
    },{"../utils/event":46,"../utils/url":52,"./driver/websocket":19,"debug":54,"events":3,"inherits":56}],39:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , AjaxBasedTransport = require('./lib/ajax-based')
      , XdrStreamingTransport = require('./xdr-streaming')
      , XhrReceiver = require('./receiver/xhr')
      , XDRObject = require('./sender/xdr')
      ;
    
    function XdrPollingTransport(transUrl) {
      if (!XDRObject.enabled) {
        throw new Error('Transport created when disabled');
      }
      AjaxBasedTransport.call(this, transUrl, '/xhr', XhrReceiver, XDRObject);
    }
    
    inherits(XdrPollingTransport, AjaxBasedTransport);
    
    XdrPollingTransport.enabled = XdrStreamingTransport.enabled;
    XdrPollingTransport.transportName = 'xdr-polling';
    XdrPollingTransport.roundTrips = 2; // preflight, ajax
    
    module.exports = XdrPollingTransport;
    
    },{"./lib/ajax-based":24,"./receiver/xhr":32,"./sender/xdr":34,"./xdr-streaming":40,"inherits":56}],40:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , AjaxBasedTransport = require('./lib/ajax-based')
      , XhrReceiver = require('./receiver/xhr')
      , XDRObject = require('./sender/xdr')
      ;
    
    // According to:
    //   http://stackoverflow.com/questions/1641507/detect-browser-support-for-cross-domain-xmlhttprequests
    //   http://hacks.mozilla.org/2009/07/cross-site-xmlhttprequest-with-cors/
    
    function XdrStreamingTransport(transUrl) {
      if (!XDRObject.enabled) {
        throw new Error('Transport created when disabled');
      }
      AjaxBasedTransport.call(this, transUrl, '/xhr_streaming', XhrReceiver, XDRObject);
    }
    
    inherits(XdrStreamingTransport, AjaxBasedTransport);
    
    XdrStreamingTransport.enabled = function(info) {
      if (info.cookie_needed || info.nullOrigin) {
        return false;
      }
      return XDRObject.enabled && info.sameScheme;
    };
    
    XdrStreamingTransport.transportName = 'xdr-streaming';
    XdrStreamingTransport.roundTrips = 2; // preflight, ajax
    
    module.exports = XdrStreamingTransport;
    
    },{"./lib/ajax-based":24,"./receiver/xhr":32,"./sender/xdr":34,"inherits":56}],41:[function(require,module,exports){
    'use strict';
    
    var inherits = require('inherits')
      , AjaxBasedTransport = require('./lib/ajax-based')
      , XhrReceiver = require('./receiver/xhr')
      , XHRCorsObject = require('./sender/xhr-cors')
      , XHRLocalObject = require('./sender/xhr-local')
      ;
    
    function XhrPollingTransport(transUrl) {
      if (!XHRLocalObject.enabled && !XHRCorsObject.enabled) {
        throw new Error('Transport created when disabled');
      }
      AjaxBasedTransport.call(this, transUrl, '/xhr', XhrReceiver, XHRCorsObject);
    }
    
    inherits(XhrPollingTransport, AjaxBasedTransport);
    
    XhrPollingTransport.enabled = function(info) {
      if (info.nullOrigin) {
        return false;
      }
    
      if (XHRLocalObject.enabled && info.sameOrigin) {
        return true;
      }
      return XHRCorsObject.enabled;
    };
    
    XhrPollingTransport.transportName = 'xhr-polling';
    XhrPollingTransport.roundTrips = 2; // preflight, ajax
    
    module.exports = XhrPollingTransport;
    
    },{"./lib/ajax-based":24,"./receiver/xhr":32,"./sender/xhr-cors":35,"./sender/xhr-local":37,"inherits":56}],42:[function(require,module,exports){
    (function (global){
    'use strict';
    
    var inherits = require('inherits')
      , AjaxBasedTransport = require('./lib/ajax-based')
      , XhrReceiver = require('./receiver/xhr')
      , XHRCorsObject = require('./sender/xhr-cors')
      , XHRLocalObject = require('./sender/xhr-local')
      , browser = require('../utils/browser')
      ;
    
    function XhrStreamingTransport(transUrl) {
      if (!XHRLocalObject.enabled && !XHRCorsObject.enabled) {
        throw new Error('Transport created when disabled');
      }
      AjaxBasedTransport.call(this, transUrl, '/xhr_streaming', XhrReceiver, XHRCorsObject);
    }
    
    inherits(XhrStreamingTransport, AjaxBasedTransport);
    
    XhrStreamingTransport.enabled = function(info) {
      if (info.nullOrigin) {
        return false;
      }
      // Opera doesn't support xhr-streaming #60
      // But it might be able to #92
      if (browser.isOpera()) {
        return false;
      }
    
      return XHRCorsObject.enabled;
    };
    
    XhrStreamingTransport.transportName = 'xhr-streaming';
    XhrStreamingTransport.roundTrips = 2; // preflight, ajax
    
    // Safari gets confused when a streaming ajax request is started
    // before onload. This causes the load indicator to spin indefinetely.
    // Only require body when used in a browser
    XhrStreamingTransport.needBody = !!global.document;
    
    module.exports = XhrStreamingTransport;
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"../utils/browser":44,"./lib/ajax-based":24,"./receiver/xhr":32,"./sender/xhr-cors":35,"./sender/xhr-local":37,"inherits":56}],43:[function(require,module,exports){
    (function (global){
    'use strict';
    
    if (global.crypto && global.crypto.getRandomValues) {
      module.exports.randomBytes = function(length) {
        var bytes = new Uint8Array(length);
        global.crypto.getRandomValues(bytes);
        return bytes;
      };
    } else {
      module.exports.randomBytes = function(length) {
        var bytes = new Array(length);
        for (var i = 0; i < length; i++) {
          bytes[i] = Math.floor(Math.random() * 256);
        }
        return bytes;
      };
    }
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{}],44:[function(require,module,exports){
    (function (global){
    'use strict';
    
    module.exports = {
      isOpera: function() {
        return global.navigator &&
          /opera/i.test(global.navigator.userAgent);
      }
    
    , isKonqueror: function() {
        return global.navigator &&
          /konqueror/i.test(global.navigator.userAgent);
      }
    
      // #187 wrap document.domain in try/catch because of WP8 from file:///
    , hasDomain: function () {
        // non-browser client always has a domain
        if (!global.document) {
          return true;
        }
    
        try {
          return !!global.document.domain;
        } catch (e) {
          return false;
        }
      }
    };
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{}],45:[function(require,module,exports){
    'use strict';
    
    var JSON3 = require('json3');
    
    // Some extra characters that Chrome gets wrong, and substitutes with
    // something else on the wire.
    // eslint-disable-next-line no-control-regex
    var extraEscapable = /[\x00-\x1f\ud800-\udfff\ufffe\uffff\u0300-\u0333\u033d-\u0346\u034a-\u034c\u0350-\u0352\u0357-\u0358\u035c-\u0362\u0374\u037e\u0387\u0591-\u05af\u05c4\u0610-\u0617\u0653-\u0654\u0657-\u065b\u065d-\u065e\u06df-\u06e2\u06eb-\u06ec\u0730\u0732-\u0733\u0735-\u0736\u073a\u073d\u073f-\u0741\u0743\u0745\u0747\u07eb-\u07f1\u0951\u0958-\u095f\u09dc-\u09dd\u09df\u0a33\u0a36\u0a59-\u0a5b\u0a5e\u0b5c-\u0b5d\u0e38-\u0e39\u0f43\u0f4d\u0f52\u0f57\u0f5c\u0f69\u0f72-\u0f76\u0f78\u0f80-\u0f83\u0f93\u0f9d\u0fa2\u0fa7\u0fac\u0fb9\u1939-\u193a\u1a17\u1b6b\u1cda-\u1cdb\u1dc0-\u1dcf\u1dfc\u1dfe\u1f71\u1f73\u1f75\u1f77\u1f79\u1f7b\u1f7d\u1fbb\u1fbe\u1fc9\u1fcb\u1fd3\u1fdb\u1fe3\u1feb\u1fee-\u1fef\u1ff9\u1ffb\u1ffd\u2000-\u2001\u20d0-\u20d1\u20d4-\u20d7\u20e7-\u20e9\u2126\u212a-\u212b\u2329-\u232a\u2adc\u302b-\u302c\uaab2-\uaab3\uf900-\ufa0d\ufa10\ufa12\ufa15-\ufa1e\ufa20\ufa22\ufa25-\ufa26\ufa2a-\ufa2d\ufa30-\ufa6d\ufa70-\ufad9\ufb1d\ufb1f\ufb2a-\ufb36\ufb38-\ufb3c\ufb3e\ufb40-\ufb41\ufb43-\ufb44\ufb46-\ufb4e\ufff0-\uffff]/g
      , extraLookup;
    
    // This may be quite slow, so let's delay until user actually uses bad
    // characters.
    var unrollLookup = function(escapable) {
      var i;
      var unrolled = {};
      var c = [];
      for (i = 0; i < 65536; i++) {
        c.push( String.fromCharCode(i) );
      }
      escapable.lastIndex = 0;
      c.join('').replace(escapable, function(a) {
        unrolled[ a ] = '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
        return '';
      });
      escapable.lastIndex = 0;
      return unrolled;
    };
    
    // Quote string, also taking care of unicode characters that browsers
    // often break. Especially, take care of unicode surrogates:
    // http://en.wikipedia.org/wiki/Mapping_of_Unicode_characters#Surrogates
    module.exports = {
      quote: function(string) {
        var quoted = JSON3.stringify(string);
    
        // In most cases this should be very fast and good enough.
        extraEscapable.lastIndex = 0;
        if (!extraEscapable.test(quoted)) {
          return quoted;
        }
    
        if (!extraLookup) {
          extraLookup = unrollLookup(extraEscapable);
        }
    
        return quoted.replace(extraEscapable, function(a) {
          return extraLookup[a];
        });
      }
    };
    
    },{"json3":57}],46:[function(require,module,exports){
    (function (global){
    'use strict';
    
    var random = require('./random');
    
    var onUnload = {}
      , afterUnload = false
        // detect google chrome packaged apps because they don't allow the 'unload' event
      , isChromePackagedApp = global.chrome && global.chrome.app && global.chrome.app.runtime
      ;
    
    module.exports = {
      attachEvent: function(event, listener) {
        if (typeof global.addEventListener !== 'undefined') {
          global.addEventListener(event, listener, false);
        } else if (global.document && global.attachEvent) {
          // IE quirks.
          // According to: http://stevesouders.com/misc/test-postmessage.php
          // the message gets delivered only to 'document', not 'window'.
          global.document.attachEvent('on' + event, listener);
          // I get 'window' for ie8.
          global.attachEvent('on' + event, listener);
        }
      }
    
    , detachEvent: function(event, listener) {
        if (typeof global.addEventListener !== 'undefined') {
          global.removeEventListener(event, listener, false);
        } else if (global.document && global.detachEvent) {
          global.document.detachEvent('on' + event, listener);
          global.detachEvent('on' + event, listener);
        }
      }
    
    , unloadAdd: function(listener) {
        if (isChromePackagedApp) {
          return null;
        }
    
        var ref = random.string(8);
        onUnload[ref] = listener;
        if (afterUnload) {
          setTimeout(this.triggerUnloadCallbacks, 0);
        }
        return ref;
      }
    
    , unloadDel: function(ref) {
        if (ref in onUnload) {
          delete onUnload[ref];
        }
      }
    
    , triggerUnloadCallbacks: function() {
        for (var ref in onUnload) {
          onUnload[ref]();
          delete onUnload[ref];
        }
      }
    };
    
    var unloadTriggered = function() {
      if (afterUnload) {
        return;
      }
      afterUnload = true;
      module.exports.triggerUnloadCallbacks();
    };
    
    // 'unload' alone is not reliable in opera within an iframe, but we
    // can't use `beforeunload` as IE fires it on javascript: links.
    if (!isChromePackagedApp) {
      module.exports.attachEvent('unload', unloadTriggered);
    }
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"./random":50}],47:[function(require,module,exports){
    (function (process,global){
    'use strict';
    
    var eventUtils = require('./event')
      , JSON3 = require('json3')
      , browser = require('./browser')
      ;
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:utils:iframe');
    }
    
    module.exports = {
      WPrefix: '_jp'
    , currentWindowId: null
    
    , polluteGlobalNamespace: function() {
        if (!(module.exports.WPrefix in global)) {
          global[module.exports.WPrefix] = {};
        }
      }
    
    , postMessage: function(type, data) {
        if (global.parent !== global) {
          global.parent.postMessage(JSON3.stringify({
            windowId: module.exports.currentWindowId
          , type: type
          , data: data || ''
          }), '*');
        } else {
          debug('Cannot postMessage, no parent window.', type, data);
        }
      }
    
    , createIframe: function(iframeUrl, errorCallback) {
        var iframe = global.document.createElement('iframe');
        var tref, unloadRef;
        var unattach = function() {
          debug('unattach');
          clearTimeout(tref);
          // Explorer had problems with that.
          try {
            iframe.onload = null;
          } catch (x) {
            // intentionally empty
          }
          iframe.onerror = null;
        };
        var cleanup = function() {
          debug('cleanup');
          if (iframe) {
            unattach();
            // This timeout makes chrome fire onbeforeunload event
            // within iframe. Without the timeout it goes straight to
            // onunload.
            setTimeout(function() {
              if (iframe) {
                iframe.parentNode.removeChild(iframe);
              }
              iframe = null;
            }, 0);
            eventUtils.unloadDel(unloadRef);
          }
        };
        var onerror = function(err) {
          debug('onerror', err);
          if (iframe) {
            cleanup();
            errorCallback(err);
          }
        };
        var post = function(msg, origin) {
          debug('post', msg, origin);
          setTimeout(function() {
            try {
              // When the iframe is not loaded, IE raises an exception
              // on 'contentWindow'.
              if (iframe && iframe.contentWindow) {
                iframe.contentWindow.postMessage(msg, origin);
              }
            } catch (x) {
              // intentionally empty
            }
          }, 0);
        };
    
        iframe.src = iframeUrl;
        iframe.style.display = 'none';
        iframe.style.position = 'absolute';
        iframe.onerror = function() {
          onerror('onerror');
        };
        iframe.onload = function() {
          debug('onload');
          // `onload` is triggered before scripts on the iframe are
          // executed. Give it few seconds to actually load stuff.
          clearTimeout(tref);
          tref = setTimeout(function() {
            onerror('onload timeout');
          }, 2000);
        };
        global.document.body.appendChild(iframe);
        tref = setTimeout(function() {
          onerror('timeout');
        }, 15000);
        unloadRef = eventUtils.unloadAdd(cleanup);
        return {
          post: post
        , cleanup: cleanup
        , loaded: unattach
        };
      }
    
    /* eslint no-undef: "off", new-cap: "off" */
    , createHtmlfile: function(iframeUrl, errorCallback) {
        var axo = ['Active'].concat('Object').join('X');
        var doc = new global[axo]('htmlfile');
        var tref, unloadRef;
        var iframe;
        var unattach = function() {
          clearTimeout(tref);
          iframe.onerror = null;
        };
        var cleanup = function() {
          if (doc) {
            unattach();
            eventUtils.unloadDel(unloadRef);
            iframe.parentNode.removeChild(iframe);
            iframe = doc = null;
            CollectGarbage();
          }
        };
        var onerror = function(r) {
          debug('onerror', r);
          if (doc) {
            cleanup();
            errorCallback(r);
          }
        };
        var post = function(msg, origin) {
          try {
            // When the iframe is not loaded, IE raises an exception
            // on 'contentWindow'.
            setTimeout(function() {
              if (iframe && iframe.contentWindow) {
                  iframe.contentWindow.postMessage(msg, origin);
              }
            }, 0);
          } catch (x) {
            // intentionally empty
          }
        };
    
        doc.open();
        doc.write('<html><s' + 'cript>' +
                  'document.domain="' + global.document.domain + '";' +
                  '</s' + 'cript></html>');
        doc.close();
        doc.parentWindow[module.exports.WPrefix] = global[module.exports.WPrefix];
        var c = doc.createElement('div');
        doc.body.appendChild(c);
        iframe = doc.createElement('iframe');
        c.appendChild(iframe);
        iframe.src = iframeUrl;
        iframe.onerror = function() {
          onerror('onerror');
        };
        tref = setTimeout(function() {
          onerror('timeout');
        }, 15000);
        unloadRef = eventUtils.unloadAdd(cleanup);
        return {
          post: post
        , cleanup: cleanup
        , loaded: unattach
        };
      }
    };
    
    module.exports.iframeEnabled = false;
    if (global.document) {
      // postMessage misbehaves in konqueror 4.6.5 - the messages are delivered with
      // huge delay, or not at all.
      module.exports.iframeEnabled = (typeof global.postMessage === 'function' ||
        typeof global.postMessage === 'object') && (!browser.isKonqueror());
    }
    
    }).call(this,{ env: {} },typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"./browser":44,"./event":46,"debug":54,"json3":57}],48:[function(require,module,exports){
    (function (global){
    'use strict';
    
    var logObject = {};
    ['log', 'debug', 'warn'].forEach(function (level) {
      var levelExists;
    
      try {
        levelExists = global.console && global.console[level] && global.console[level].apply;
      } catch(e) {
        // do nothing
      }
    
      logObject[level] = levelExists ? function () {
        return global.console[level].apply(global.console, arguments);
      } : (level === 'log' ? function () {} : logObject.log);
    });
    
    module.exports = logObject;
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{}],49:[function(require,module,exports){
    'use strict';
    
    module.exports = {
      isObject: function(obj) {
        var type = typeof obj;
        return type === 'function' || type === 'object' && !!obj;
      }
    
    , extend: function(obj) {
        if (!this.isObject(obj)) {
          return obj;
        }
        var source, prop;
        for (var i = 1, length = arguments.length; i < length; i++) {
          source = arguments[i];
          for (prop in source) {
            if (Object.prototype.hasOwnProperty.call(source, prop)) {
              obj[prop] = source[prop];
            }
          }
        }
        return obj;
      }
    };
    
    },{}],50:[function(require,module,exports){
    'use strict';
    
    /* global crypto:true */
    var crypto = require('crypto');
    
    // This string has length 32, a power of 2, so the modulus doesn't introduce a
    // bias.
    var _randomStringChars = 'abcdefghijklmnopqrstuvwxyz012345';
    module.exports = {
      string: function(length) {
        var max = _randomStringChars.length;
        var bytes = crypto.randomBytes(length);
        var ret = [];
        for (var i = 0; i < length; i++) {
          ret.push(_randomStringChars.substr(bytes[i] % max, 1));
        }
        return ret.join('');
      }
    
    , number: function(max) {
        return Math.floor(Math.random() * max);
      }
    
    , numberString: function(max) {
        var t = ('' + (max - 1)).length;
        var p = new Array(t + 1).join('0');
        return (p + this.number(max)).slice(-t);
      }
    };
    
    },{"crypto":43}],51:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:utils:transport');
    }
    
    module.exports = function(availableTransports) {
      return {
        filterToEnabled: function(transportsWhitelist, info) {
          var transports = {
            main: []
          , facade: []
          };
          if (!transportsWhitelist) {
            transportsWhitelist = [];
          } else if (typeof transportsWhitelist === 'string') {
            transportsWhitelist = [transportsWhitelist];
          }
    
          availableTransports.forEach(function(trans) {
            if (!trans) {
              return;
            }
    
            if (trans.transportName === 'websocket' && info.websocket === false) {
              debug('disabled from server', 'websocket');
              return;
            }
    
            if (transportsWhitelist.length &&
                transportsWhitelist.indexOf(trans.transportName) === -1) {
              debug('not in whitelist', trans.transportName);
              return;
            }
    
            if (trans.enabled(info)) {
              debug('enabled', trans.transportName);
              transports.main.push(trans);
              if (trans.facadeTransport) {
                transports.facade.push(trans.facadeTransport);
              }
            } else {
              debug('disabled', trans.transportName);
            }
          });
          return transports;
        }
      };
    };
    
    }).call(this,{ env: {} })
    
    },{"debug":54}],52:[function(require,module,exports){
    (function (process){
    'use strict';
    
    var URL = require('url-parse');
    
    var debug = function() {};
    if (process.env.NODE_ENV !== 'production') {
      debug = require('debug')('sockjs-client:utils:url');
    }
    
    module.exports = {
      getOrigin: function(url) {
        if (!url) {
          return null;
        }
    
        var p = new URL(url);
        if (p.protocol === 'file:') {
          return null;
        }
    
        var port = p.port;
        if (!port) {
          port = (p.protocol === 'https:') ? '443' : '80';
        }
    
        return p.protocol + '//' + p.hostname + ':' + port;
      }
    
    , isOriginEqual: function(a, b) {
        var res = this.getOrigin(a) === this.getOrigin(b);
        debug('same', a, b, res);
        return res;
      }
    
    , isSchemeEqual: function(a, b) {
        return (a.split(':')[0] === b.split(':')[0]);
      }
    
    , addPath: function (url, path) {
        var qs = url.split('?');
        return qs[0] + path + (qs[1] ? '?' + qs[1] : '');
      }
    
    , addQuery: function (url, q) {
        return url + (url.indexOf('?') === -1 ? ('?' + q) : ('&' + q));
      }
    };
    
    }).call(this,{ env: {} })
    
    },{"debug":54,"url-parse":61}],53:[function(require,module,exports){
    module.exports = '1.1.5';
    
    },{}],54:[function(require,module,exports){
    (function (process){
    /**
     * This is the web browser implementation of `debug()`.
     *
     * Expose `debug()` as the module.
     */
    
    exports = module.exports = require('./debug');
    exports.log = log;
    exports.formatArgs = formatArgs;
    exports.save = save;
    exports.load = load;
    exports.useColors = useColors;
    exports.storage = 'undefined' != typeof chrome
                   && 'undefined' != typeof chrome.storage
                      ? chrome.storage.local
                      : localstorage();
    
    /**
     * Colors.
     */
    
    exports.colors = [
      'lightseagreen',
      'forestgreen',
      'goldenrod',
      'dodgerblue',
      'darkorchid',
      'crimson'
    ];
    
    /**
     * Currently only WebKit-based Web Inspectors, Firefox >= v31,
     * and the Firebug extension (any Firefox version) are known
     * to support "%c" CSS customizations.
     *
     * TODO: add a `localStorage` variable to explicitly enable/disable colors
     */
    
    function useColors() {
      // NB: In an Electron preload script, document will be defined but not fully
      // initialized. Since we know we're in Chrome, we'll just detect this case
      // explicitly
      if (typeof window !== 'undefined' && window.process && window.process.type === 'renderer') {
        return true;
      }
    
      // is webkit? http://stackoverflow.com/a/16459606/376773
      // document is undefined in react-native: https://github.com/facebook/react-native/pull/1632
      return (typeof document !== 'undefined' && document.documentElement && document.documentElement.style && document.documentElement.style.WebkitAppearance) ||
        // is firebug? http://stackoverflow.com/a/398120/376773
        (typeof window !== 'undefined' && window.console && (window.console.firebug || (window.console.exception && window.console.table))) ||
        // is firefox >= v31?
        // https://developer.mozilla.org/en-US/docs/Tools/Web_Console#Styling_messages
        (typeof navigator !== 'undefined' && navigator.userAgent && navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/) && parseInt(RegExp.$1, 10) >= 31) ||
        // double check webkit in userAgent just in case we are in a worker
        (typeof navigator !== 'undefined' && navigator.userAgent && navigator.userAgent.toLowerCase().match(/applewebkit\/(\d+)/));
    }
    
    /**
     * Map %j to `JSON.stringify()`, since no Web Inspectors do that by default.
     */
    
    exports.formatters.j = function(v) {
      try {
        return JSON.stringify(v);
      } catch (err) {
        return '[UnexpectedJSONParseError]: ' + err.message;
      }
    };
    
    
    /**
     * Colorize log arguments if enabled.
     *
     * @api public
     */
    
    function formatArgs(args) {
      var useColors = this.useColors;
    
      args[0] = (useColors ? '%c' : '')
        + this.namespace
        + (useColors ? ' %c' : ' ')
        + args[0]
        + (useColors ? '%c ' : ' ')
        + '+' + exports.humanize(this.diff);
    
      if (!useColors) return;
    
      var c = 'color: ' + this.color;
      args.splice(1, 0, c, 'color: inherit')
    
      // the final "%c" is somewhat tricky, because there could be other
      // arguments passed either before or after the %c, so we need to
      // figure out the correct index to insert the CSS into
      var index = 0;
      var lastC = 0;
      args[0].replace(/%[a-zA-Z%]/g, function(match) {
        if ('%%' === match) return;
        index++;
        if ('%c' === match) {
          // we only are interested in the *last* %c
          // (the user may have provided their own)
          lastC = index;
        }
      });
    
      args.splice(lastC, 0, c);
    }
    
    /**
     * Invokes `console.log()` when available.
     * No-op when `console.log` is not a "function".
     *
     * @api public
     */
    
    function log() {
      // this hackery is required for IE8/9, where
      // the `console.log` function doesn't have 'apply'
      return 'object' === typeof console
        && console.log
        && Function.prototype.apply.call(console.log, console, arguments);
    }
    
    /**
     * Save `namespaces`.
     *
     * @param {String} namespaces
     * @api private
     */
    
    function save(namespaces) {
      try {
        if (null == namespaces) {
          exports.storage.removeItem('debug');
        } else {
          exports.storage.debug = namespaces;
        }
      } catch(e) {}
    }
    
    /**
     * Load `namespaces`.
     *
     * @return {String} returns the previously persisted debug modes
     * @api private
     */
    
    function load() {
      var r;
      try {
        r = exports.storage.debug;
      } catch(e) {}
    
      // If debug isn't set in LS, and we're in Electron, try to load $DEBUG
      if (!r && typeof process !== 'undefined' && 'env' in process) {
        r = process.env.DEBUG;
      }
    
      return r;
    }
    
    /**
     * Enable namespaces listed in `localStorage.debug` initially.
     */
    
    exports.enable(load());
    
    /**
     * Localstorage attempts to return the localstorage.
     *
     * This is necessary because safari throws
     * when a user disables cookies/localstorage
     * and you attempt to access it.
     *
     * @return {LocalStorage}
     * @api private
     */
    
    function localstorage() {
      try {
        return window.localStorage;
      } catch (e) {}
    }
    
    }).call(this,{ env: {} })
    
    },{"./debug":55}],55:[function(require,module,exports){
    
    /**
     * This is the common logic for both the Node.js and web browser
     * implementations of `debug()`.
     *
     * Expose `debug()` as the module.
     */
    
    exports = module.exports = createDebug.debug = createDebug['default'] = createDebug;
    exports.coerce = coerce;
    exports.disable = disable;
    exports.enable = enable;
    exports.enabled = enabled;
    exports.humanize = require('ms');
    
    /**
     * The currently active debug mode names, and names to skip.
     */
    
    exports.names = [];
    exports.skips = [];
    
    /**
     * Map of special "%n" handling functions, for the debug "format" argument.
     *
     * Valid key names are a single, lower or upper-case letter, i.e. "n" and "N".
     */
    
    exports.formatters = {};
    
    /**
     * Previous log timestamp.
     */
    
    var prevTime;
    
    /**
     * Select a color.
     * @param {String} namespace
     * @return {Number}
     * @api private
     */
    
    function selectColor(namespace) {
      var hash = 0, i;
    
      for (i in namespace) {
        hash  = ((hash << 5) - hash) + namespace.charCodeAt(i);
        hash |= 0; // Convert to 32bit integer
      }
    
      return exports.colors[Math.abs(hash) % exports.colors.length];
    }
    
    /**
     * Create a debugger with the given `namespace`.
     *
     * @param {String} namespace
     * @return {Function}
     * @api public
     */
    
    function createDebug(namespace) {
    
      function debug() {
        // disabled?
        if (!debug.enabled) return;
    
        var self = debug;
    
        // set `diff` timestamp
        var curr = +new Date();
        var ms = curr - (prevTime || curr);
        self.diff = ms;
        self.prev = prevTime;
        self.curr = curr;
        prevTime = curr;
    
        // turn the `arguments` into a proper Array
        var args = new Array(arguments.length);
        for (var i = 0; i < args.length; i++) {
          args[i] = arguments[i];
        }
    
        args[0] = exports.coerce(args[0]);
    
        if ('string' !== typeof args[0]) {
          // anything else let's inspect with %O
          args.unshift('%O');
        }
    
        // apply any `formatters` transformations
        var index = 0;
        args[0] = args[0].replace(/%([a-zA-Z%])/g, function(match, format) {
          // if we encounter an escaped % then don't increase the array index
          if (match === '%%') return match;
          index++;
          var formatter = exports.formatters[format];
          if ('function' === typeof formatter) {
            var val = args[index];
            match = formatter.call(self, val);
    
            // now we need to remove `args[index]` since it's inlined in the `format`
            args.splice(index, 1);
            index--;
          }
          return match;
        });
    
        // apply env-specific formatting (colors, etc.)
        exports.formatArgs.call(self, args);
    
        var logFn = debug.log || exports.log || console.log.bind(console);
        logFn.apply(self, args);
      }
    
      debug.namespace = namespace;
      debug.enabled = exports.enabled(namespace);
      debug.useColors = exports.useColors();
      debug.color = selectColor(namespace);
    
      // env-specific initialization logic for debug instances
      if ('function' === typeof exports.init) {
        exports.init(debug);
      }
    
      return debug;
    }
    
    /**
     * Enables a debug mode by namespaces. This can include modes
     * separated by a colon and wildcards.
     *
     * @param {String} namespaces
     * @api public
     */
    
    function enable(namespaces) {
      exports.save(namespaces);
    
      exports.names = [];
      exports.skips = [];
    
      var split = (typeof namespaces === 'string' ? namespaces : '').split(/[\s,]+/);
      var len = split.length;
    
      for (var i = 0; i < len; i++) {
        if (!split[i]) continue; // ignore empty strings
        namespaces = split[i].replace(/\*/g, '.*?');
        if (namespaces[0] === '-') {
          exports.skips.push(new RegExp('^' + namespaces.substr(1) + '$'));
        } else {
          exports.names.push(new RegExp('^' + namespaces + '$'));
        }
      }
    }
    
    /**
     * Disable debug output.
     *
     * @api public
     */
    
    function disable() {
      exports.enable('');
    }
    
    /**
     * Returns true if the given mode name is enabled, false otherwise.
     *
     * @param {String} name
     * @return {Boolean}
     * @api public
     */
    
    function enabled(name) {
      var i, len;
      for (i = 0, len = exports.skips.length; i < len; i++) {
        if (exports.skips[i].test(name)) {
          return false;
        }
      }
      for (i = 0, len = exports.names.length; i < len; i++) {
        if (exports.names[i].test(name)) {
          return true;
        }
      }
      return false;
    }
    
    /**
     * Coerce `val`.
     *
     * @param {Mixed} val
     * @return {Mixed}
     * @api private
     */
    
    function coerce(val) {
      if (val instanceof Error) return val.stack || val.message;
      return val;
    }
    
    },{"ms":58}],56:[function(require,module,exports){
    if (typeof Object.create === 'function') {
      // implementation from standard node.js 'util' module
      module.exports = function inherits(ctor, superCtor) {
        ctor.super_ = superCtor
        ctor.prototype = Object.create(superCtor.prototype, {
          constructor: {
            value: ctor,
            enumerable: false,
            writable: true,
            configurable: true
          }
        });
      };
    } else {
      // old school shim for old browsers
      module.exports = function inherits(ctor, superCtor) {
        ctor.super_ = superCtor
        var TempCtor = function () {}
        TempCtor.prototype = superCtor.prototype
        ctor.prototype = new TempCtor()
        ctor.prototype.constructor = ctor
      }
    }
    
    },{}],57:[function(require,module,exports){
    (function (global){
    /*! JSON v3.3.2 | http://bestiejs.github.io/json3 | Copyright 2012-2014, Kit Cambridge | http://kit.mit-license.org */
    ;(function () {
      // Detect the `define` function exposed by asynchronous module loaders. The
      // strict `define` check is necessary for compatibility with `r.js`.
      var isLoader = typeof define === "function" && define.amd;
    
      // A set of types used to distinguish objects from primitives.
      var objectTypes = {
        "function": true,
        "object": true
      };
    
      // Detect the `exports` object exposed by CommonJS implementations.
      var freeExports = objectTypes[typeof exports] && exports && !exports.nodeType && exports;
    
      // Use the `global` object exposed by Node (including Browserify via
      // `insert-module-globals`), Narwhal, and Ringo as the default context,
      // and the `window` object in browsers. Rhino exports a `global` function
      // instead.
      var root = objectTypes[typeof window] && window || this,
          freeGlobal = freeExports && objectTypes[typeof module] && module && !module.nodeType && typeof global == "object" && global;
    
      if (freeGlobal && (freeGlobal["global"] === freeGlobal || freeGlobal["window"] === freeGlobal || freeGlobal["self"] === freeGlobal)) {
        root = freeGlobal;
      }
    
      // Public: Initializes JSON 3 using the given `context` object, attaching the
      // `stringify` and `parse` functions to the specified `exports` object.
      function runInContext(context, exports) {
        context || (context = root["Object"]());
        exports || (exports = root["Object"]());
    
        // Native constructor aliases.
        var Number = context["Number"] || root["Number"],
            String = context["String"] || root["String"],
            Object = context["Object"] || root["Object"],
            Date = context["Date"] || root["Date"],
            SyntaxError = context["SyntaxError"] || root["SyntaxError"],
            TypeError = context["TypeError"] || root["TypeError"],
            Math = context["Math"] || root["Math"],
            nativeJSON = context["JSON"] || root["JSON"];
    
        // Delegate to the native `stringify` and `parse` implementations.
        if (typeof nativeJSON == "object" && nativeJSON) {
          exports.stringify = nativeJSON.stringify;
          exports.parse = nativeJSON.parse;
        }
    
        // Convenience aliases.
        var objectProto = Object.prototype,
            getClass = objectProto.toString,
            isProperty, forEach, undef;
    
        // Test the `Date#getUTC*` methods. Based on work by @Yaffle.
        var isExtended = new Date(-3509827334573292);
        try {
          // The `getUTCFullYear`, `Month`, and `Date` methods return nonsensical
          // results for certain dates in Opera >= 10.53.
          isExtended = isExtended.getUTCFullYear() == -109252 && isExtended.getUTCMonth() === 0 && isExtended.getUTCDate() === 1 &&
            // Safari < 2.0.2 stores the internal millisecond time value correctly,
            // but clips the values returned by the date methods to the range of
            // signed 32-bit integers ([-2 ** 31, 2 ** 31 - 1]).
            isExtended.getUTCHours() == 10 && isExtended.getUTCMinutes() == 37 && isExtended.getUTCSeconds() == 6 && isExtended.getUTCMilliseconds() == 708;
        } catch (exception) {}
    
        // Internal: Determines whether the native `JSON.stringify` and `parse`
        // implementations are spec-compliant. Based on work by Ken Snyder.
        function has(name) {
          if (has[name] !== undef) {
            // Return cached feature test result.
            return has[name];
          }
          var isSupported;
          if (name == "bug-string-char-index") {
            // IE <= 7 doesn't support accessing string characters using square
            // bracket notation. IE 8 only supports this for primitives.
            isSupported = "a"[0] != "a";
          } else if (name == "json") {
            // Indicates whether both `JSON.stringify` and `JSON.parse` are
            // supported.
            isSupported = has("json-stringify") && has("json-parse");
          } else {
            var value, serialized = '{"a":[1,true,false,null,"\\u0000\\b\\n\\f\\r\\t"]}';
            // Test `JSON.stringify`.
            if (name == "json-stringify") {
              var stringify = exports.stringify, stringifySupported = typeof stringify == "function" && isExtended;
              if (stringifySupported) {
                // A test function object with a custom `toJSON` method.
                (value = function () {
                  return 1;
                }).toJSON = value;
                try {
                  stringifySupported =
                    // Firefox 3.1b1 and b2 serialize string, number, and boolean
                    // primitives as object literals.
                    stringify(0) === "0" &&
                    // FF 3.1b1, b2, and JSON 2 serialize wrapped primitives as object
                    // literals.
                    stringify(new Number()) === "0" &&
                    stringify(new String()) == '""' &&
                    // FF 3.1b1, 2 throw an error if the value is `null`, `undefined`, or
                    // does not define a canonical JSON representation (this applies to
                    // objects with `toJSON` properties as well, *unless* they are nested
                    // within an object or array).
                    stringify(getClass) === undef &&
                    // IE 8 serializes `undefined` as `"undefined"`. Safari <= 5.1.7 and
                    // FF 3.1b3 pass this test.
                    stringify(undef) === undef &&
                    // Safari <= 5.1.7 and FF 3.1b3 throw `Error`s and `TypeError`s,
                    // respectively, if the value is omitted entirely.
                    stringify() === undef &&
                    // FF 3.1b1, 2 throw an error if the given value is not a number,
                    // string, array, object, Boolean, or `null` literal. This applies to
                    // objects with custom `toJSON` methods as well, unless they are nested
                    // inside object or array literals. YUI 3.0.0b1 ignores custom `toJSON`
                    // methods entirely.
                    stringify(value) === "1" &&
                    stringify([value]) == "[1]" &&
                    // Prototype <= 1.6.1 serializes `[undefined]` as `"[]"` instead of
                    // `"[null]"`.
                    stringify([undef]) == "[null]" &&
                    // YUI 3.0.0b1 fails to serialize `null` literals.
                    stringify(null) == "null" &&
                    // FF 3.1b1, 2 halts serialization if an array contains a function:
                    // `[1, true, getClass, 1]` serializes as "[1,true,],". FF 3.1b3
                    // elides non-JSON values from objects and arrays, unless they
                    // define custom `toJSON` methods.
                    stringify([undef, getClass, null]) == "[null,null,null]" &&
                    // Simple serialization test. FF 3.1b1 uses Unicode escape sequences
                    // where character escape codes are expected (e.g., `\b` => `\u0008`).
                    stringify({ "a": [value, true, false, null, "\x00\b\n\f\r\t"] }) == serialized &&
                    // FF 3.1b1 and b2 ignore the `filter` and `width` arguments.
                    stringify(null, value) === "1" &&
                    stringify([1, 2], null, 1) == "[\n 1,\n 2\n]" &&
                    // JSON 2, Prototype <= 1.7, and older WebKit builds incorrectly
                    // serialize extended years.
                    stringify(new Date(-8.64e15)) == '"-271821-04-20T00:00:00.000Z"' &&
                    // The milliseconds are optional in ES 5, but required in 5.1.
                    stringify(new Date(8.64e15)) == '"+275760-09-13T00:00:00.000Z"' &&
                    // Firefox <= 11.0 incorrectly serializes years prior to 0 as negative
                    // four-digit years instead of six-digit years. Credits: @Yaffle.
                    stringify(new Date(-621987552e5)) == '"-000001-01-01T00:00:00.000Z"' &&
                    // Safari <= 5.1.5 and Opera >= 10.53 incorrectly serialize millisecond
                    // values less than 1000. Credits: @Yaffle.
                    stringify(new Date(-1)) == '"1969-12-31T23:59:59.999Z"';
                } catch (exception) {
                  stringifySupported = false;
                }
              }
              isSupported = stringifySupported;
            }
            // Test `JSON.parse`.
            if (name == "json-parse") {
              var parse = exports.parse;
              if (typeof parse == "function") {
                try {
                  // FF 3.1b1, b2 will throw an exception if a bare literal is provided.
                  // Conforming implementations should also coerce the initial argument to
                  // a string prior to parsing.
                  if (parse("0") === 0 && !parse(false)) {
                    // Simple parsing test.
                    value = parse(serialized);
                    var parseSupported = value["a"].length == 5 && value["a"][0] === 1;
                    if (parseSupported) {
                      try {
                        // Safari <= 5.1.2 and FF 3.1b1 allow unescaped tabs in strings.
                        parseSupported = !parse('"\t"');
                      } catch (exception) {}
                      if (parseSupported) {
                        try {
                          // FF 4.0 and 4.0.1 allow leading `+` signs and leading
                          // decimal points. FF 4.0, 4.0.1, and IE 9-10 also allow
                          // certain octal literals.
                          parseSupported = parse("01") !== 1;
                        } catch (exception) {}
                      }
                      if (parseSupported) {
                        try {
                          // FF 4.0, 4.0.1, and Rhino 1.7R3-R4 allow trailing decimal
                          // points. These environments, along with FF 3.1b1 and 2,
                          // also allow trailing commas in JSON objects and arrays.
                          parseSupported = parse("1.") !== 1;
                        } catch (exception) {}
                      }
                    }
                  }
                } catch (exception) {
                  parseSupported = false;
                }
              }
              isSupported = parseSupported;
            }
          }
          return has[name] = !!isSupported;
        }
    
        if (!has("json")) {
          // Common `[[Class]]` name aliases.
          var functionClass = "[object Function]",
              dateClass = "[object Date]",
              numberClass = "[object Number]",
              stringClass = "[object String]",
              arrayClass = "[object Array]",
              booleanClass = "[object Boolean]";
    
          // Detect incomplete support for accessing string characters by index.
          var charIndexBuggy = has("bug-string-char-index");
    
          // Define additional utility methods if the `Date` methods are buggy.
          if (!isExtended) {
            var floor = Math.floor;
            // A mapping between the months of the year and the number of days between
            // January 1st and the first of the respective month.
            var Months = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334];
            // Internal: Calculates the number of days between the Unix epoch and the
            // first day of the given month.
            var getDay = function (year, month) {
              return Months[month] + 365 * (year - 1970) + floor((year - 1969 + (month = +(month > 1))) / 4) - floor((year - 1901 + month) / 100) + floor((year - 1601 + month) / 400);
            };
          }
    
          // Internal: Determines if a property is a direct property of the given
          // object. Delegates to the native `Object#hasOwnProperty` method.
          if (!(isProperty = objectProto.hasOwnProperty)) {
            isProperty = function (property) {
              var members = {}, constructor;
              if ((members.__proto__ = null, members.__proto__ = {
                // The *proto* property cannot be set multiple times in recent
                // versions of Firefox and SeaMonkey.
                "toString": 1
              }, members).toString != getClass) {
                // Safari <= 2.0.3 doesn't implement `Object#hasOwnProperty`, but
                // supports the mutable *proto* property.
                isProperty = function (property) {
                  // Capture and break the object's prototype chain (see section 8.6.2
                  // of the ES 5.1 spec). The parenthesized expression prevents an
                  // unsafe transformation by the Closure Compiler.
                  var original = this.__proto__, result = property in (this.__proto__ = null, this);
                  // Restore the original prototype chain.
                  this.__proto__ = original;
                  return result;
                };
              } else {
                // Capture a reference to the top-level `Object` constructor.
                constructor = members.constructor;
                // Use the `constructor` property to simulate `Object#hasOwnProperty` in
                // other environments.
                isProperty = function (property) {
                  var parent = (this.constructor || constructor).prototype;
                  return property in this && !(property in parent && this[property] === parent[property]);
                };
              }
              members = null;
              return isProperty.call(this, property);
            };
          }
    
          // Internal: Normalizes the `for...in` iteration algorithm across
          // environments. Each enumerated key is yielded to a `callback` function.
          forEach = function (object, callback) {
            var size = 0, Properties, members, property;
    
            // Tests for bugs in the current environment's `for...in` algorithm. The
            // `valueOf` property inherits the non-enumerable flag from
            // `Object.prototype` in older versions of IE, Netscape, and Mozilla.
            (Properties = function () {
              this.valueOf = 0;
            }).prototype.valueOf = 0;
    
            // Iterate over a new instance of the `Properties` class.
            members = new Properties();
            for (property in members) {
              // Ignore all properties inherited from `Object.prototype`.
              if (isProperty.call(members, property)) {
                size++;
              }
            }
            Properties = members = null;
    
            // Normalize the iteration algorithm.
            if (!size) {
              // A list of non-enumerable properties inherited from `Object.prototype`.
              members = ["valueOf", "toString", "toLocaleString", "propertyIsEnumerable", "isPrototypeOf", "hasOwnProperty", "constructor"];
              // IE <= 8, Mozilla 1.0, and Netscape 6.2 ignore shadowed non-enumerable
              // properties.
              forEach = function (object, callback) {
                var isFunction = getClass.call(object) == functionClass, property, length;
                var hasProperty = !isFunction && typeof object.constructor != "function" && objectTypes[typeof object.hasOwnProperty] && object.hasOwnProperty || isProperty;
                for (property in object) {
                  // Gecko <= 1.0 enumerates the `prototype` property of functions under
                  // certain conditions; IE does not.
                  if (!(isFunction && property == "prototype") && hasProperty.call(object, property)) {
                    callback(property);
                  }
                }
                // Manually invoke the callback for each non-enumerable property.
                for (length = members.length; property = members[--length]; hasProperty.call(object, property) && callback(property));
              };
            } else if (size == 2) {
              // Safari <= 2.0.4 enumerates shadowed properties twice.
              forEach = function (object, callback) {
                // Create a set of iterated properties.
                var members = {}, isFunction = getClass.call(object) == functionClass, property;
                for (property in object) {
                  // Store each property name to prevent double enumeration. The
                  // `prototype` property of functions is not enumerated due to cross-
                  // environment inconsistencies.
                  if (!(isFunction && property == "prototype") && !isProperty.call(members, property) && (members[property] = 1) && isProperty.call(object, property)) {
                    callback(property);
                  }
                }
              };
            } else {
              // No bugs detected; use the standard `for...in` algorithm.
              forEach = function (object, callback) {
                var isFunction = getClass.call(object) == functionClass, property, isConstructor;
                for (property in object) {
                  if (!(isFunction && property == "prototype") && isProperty.call(object, property) && !(isConstructor = property === "constructor")) {
                    callback(property);
                  }
                }
                // Manually invoke the callback for the `constructor` property due to
                // cross-environment inconsistencies.
                if (isConstructor || isProperty.call(object, (property = "constructor"))) {
                  callback(property);
                }
              };
            }
            return forEach(object, callback);
          };
    
          // Public: Serializes a JavaScript `value` as a JSON string. The optional
          // `filter` argument may specify either a function that alters how object and
          // array members are serialized, or an array of strings and numbers that
          // indicates which properties should be serialized. The optional `width`
          // argument may be either a string or number that specifies the indentation
          // level of the output.
          if (!has("json-stringify")) {
            // Internal: A map of control characters and their escaped equivalents.
            var Escapes = {
              92: "\\\\",
              34: '\\"',
              8: "\\b",
              12: "\\f",
              10: "\\n",
              13: "\\r",
              9: "\\t"
            };
    
            // Internal: Converts `value` into a zero-padded string such that its
            // length is at least equal to `width`. The `width` must be <= 6.
            var leadingZeroes = "000000";
            var toPaddedString = function (width, value) {
              // The `|| 0` expression is necessary to work around a bug in
              // Opera <= 7.54u2 where `0 == -0`, but `String(-0) !== "0"`.
              return (leadingZeroes + (value || 0)).slice(-width);
            };
    
            // Internal: Double-quotes a string `value`, replacing all ASCII control
            // characters (characters with code unit values between 0 and 31) with
            // their escaped equivalents. This is an implementation of the
            // `Quote(value)` operation defined in ES 5.1 section 15.12.3.
            var unicodePrefix = "\\u00";
            var quote = function (value) {
              var result = '"', index = 0, length = value.length, useCharIndex = !charIndexBuggy || length > 10;
              var symbols = useCharIndex && (charIndexBuggy ? value.split("") : value);
              for (; index < length; index++) {
                var charCode = value.charCodeAt(index);
                // If the character is a control character, append its Unicode or
                // shorthand escape sequence; otherwise, append the character as-is.
                switch (charCode) {
                  case 8: case 9: case 10: case 12: case 13: case 34: case 92:
                    result += Escapes[charCode];
                    break;
                  default:
                    if (charCode < 32) {
                      result += unicodePrefix + toPaddedString(2, charCode.toString(16));
                      break;
                    }
                    result += useCharIndex ? symbols[index] : value.charAt(index);
                }
              }
              return result + '"';
            };
    
            // Internal: Recursively serializes an object. Implements the
            // `Str(key, holder)`, `JO(value)`, and `JA(value)` operations.
            var serialize = function (property, object, callback, properties, whitespace, indentation, stack) {
              var value, className, year, month, date, time, hours, minutes, seconds, milliseconds, results, element, index, length, prefix, result;
              try {
                // Necessary for host object support.
                value = object[property];
              } catch (exception) {}
              if (typeof value == "object" && value) {
                className = getClass.call(value);
                if (className == dateClass && !isProperty.call(value, "toJSON")) {
                  if (value > -1 / 0 && value < 1 / 0) {
                    // Dates are serialized according to the `Date#toJSON` method
                    // specified in ES 5.1 section 15.9.5.44. See section 15.9.1.15
                    // for the ISO 8601 date time string format.
                    if (getDay) {
                      // Manually compute the year, month, date, hours, minutes,
                      // seconds, and milliseconds if the `getUTC*` methods are
                      // buggy. Adapted from @Yaffle's `date-shim` project.
                      date = floor(value / 864e5);
                      for (year = floor(date / 365.2425) + 1970 - 1; getDay(year + 1, 0) <= date; year++);
                      for (month = floor((date - getDay(year, 0)) / 30.42); getDay(year, month + 1) <= date; month++);
                      date = 1 + date - getDay(year, month);
                      // The `time` value specifies the time within the day (see ES
                      // 5.1 section 15.9.1.2). The formula `(A % B + B) % B` is used
                      // to compute `A modulo B`, as the `%` operator does not
                      // correspond to the `modulo` operation for negative numbers.
                      time = (value % 864e5 + 864e5) % 864e5;
                      // The hours, minutes, seconds, and milliseconds are obtained by
                      // decomposing the time within the day. See section 15.9.1.10.
                      hours = floor(time / 36e5) % 24;
                      minutes = floor(time / 6e4) % 60;
                      seconds = floor(time / 1e3) % 60;
                      milliseconds = time % 1e3;
                    } else {
                      year = value.getUTCFullYear();
                      month = value.getUTCMonth();
                      date = value.getUTCDate();
                      hours = value.getUTCHours();
                      minutes = value.getUTCMinutes();
                      seconds = value.getUTCSeconds();
                      milliseconds = value.getUTCMilliseconds();
                    }
                    // Serialize extended years correctly.
                    value = (year <= 0 || year >= 1e4 ? (year < 0 ? "-" : "+") + toPaddedString(6, year < 0 ? -year : year) : toPaddedString(4, year)) +
                      "-" + toPaddedString(2, month + 1) + "-" + toPaddedString(2, date) +
                      // Months, dates, hours, minutes, and seconds should have two
                      // digits; milliseconds should have three.
                      "T" + toPaddedString(2, hours) + ":" + toPaddedString(2, minutes) + ":" + toPaddedString(2, seconds) +
                      // Milliseconds are optional in ES 5.0, but required in 5.1.
                      "." + toPaddedString(3, milliseconds) + "Z";
                  } else {
                    value = null;
                  }
                } else if (typeof value.toJSON == "function" && ((className != numberClass && className != stringClass && className != arrayClass) || isProperty.call(value, "toJSON"))) {
                  // Prototype <= 1.6.1 adds non-standard `toJSON` methods to the
                  // `Number`, `String`, `Date`, and `Array` prototypes. JSON 3
                  // ignores all `toJSON` methods on these objects unless they are
                  // defined directly on an instance.
                  value = value.toJSON(property);
                }
              }
              if (callback) {
                // If a replacement function was provided, call it to obtain the value
                // for serialization.
                value = callback.call(object, property, value);
              }
              if (value === null) {
                return "null";
              }
              className = getClass.call(value);
              if (className == booleanClass) {
                // Booleans are represented literally.
                return "" + value;
              } else if (className == numberClass) {
                // JSON numbers must be finite. `Infinity` and `NaN` are serialized as
                // `"null"`.
                return value > -1 / 0 && value < 1 / 0 ? "" + value : "null";
              } else if (className == stringClass) {
                // Strings are double-quoted and escaped.
                return quote("" + value);
              }
              // Recursively serialize objects and arrays.
              if (typeof value == "object") {
                // Check for cyclic structures. This is a linear search; performance
                // is inversely proportional to the number of unique nested objects.
                for (length = stack.length; length--;) {
                  if (stack[length] === value) {
                    // Cyclic structures cannot be serialized by `JSON.stringify`.
                    throw TypeError();
                  }
                }
                // Add the object to the stack of traversed objects.
                stack.push(value);
                results = [];
                // Save the current indentation level and indent one additional level.
                prefix = indentation;
                indentation += whitespace;
                if (className == arrayClass) {
                  // Recursively serialize array elements.
                  for (index = 0, length = value.length; index < length; index++) {
                    element = serialize(index, value, callback, properties, whitespace, indentation, stack);
                    results.push(element === undef ? "null" : element);
                  }
                  result = results.length ? (whitespace ? "[\n" + indentation + results.join(",\n" + indentation) + "\n" + prefix + "]" : ("[" + results.join(",") + "]")) : "[]";
                } else {
                  // Recursively serialize object members. Members are selected from
                  // either a user-specified list of property names, or the object
                  // itself.
                  forEach(properties || value, function (property) {
                    var element = serialize(property, value, callback, properties, whitespace, indentation, stack);
                    if (element !== undef) {
                      // According to ES 5.1 section 15.12.3: "If `gap` {whitespace}
                      // is not the empty string, let `member` {quote(property) + ":"}
                      // be the concatenation of `member` and the `space` character."
                      // The "`space` character" refers to the literal space
                      // character, not the `space` {width} argument provided to
                      // `JSON.stringify`.
                      results.push(quote(property) + ":" + (whitespace ? " " : "") + element);
                    }
                  });
                  result = results.length ? (whitespace ? "{\n" + indentation + results.join(",\n" + indentation) + "\n" + prefix + "}" : ("{" + results.join(",") + "}")) : "{}";
                }
                // Remove the object from the traversed object stack.
                stack.pop();
                return result;
              }
            };
    
            // Public: `JSON.stringify`. See ES 5.1 section 15.12.3.
            exports.stringify = function (source, filter, width) {
              var whitespace, callback, properties, className;
              if (objectTypes[typeof filter] && filter) {
                if ((className = getClass.call(filter)) == functionClass) {
                  callback = filter;
                } else if (className == arrayClass) {
                  // Convert the property names array into a makeshift set.
                  properties = {};
                  for (var index = 0, length = filter.length, value; index < length; value = filter[index++], ((className = getClass.call(value)), className == stringClass || className == numberClass) && (properties[value] = 1));
                }
              }
              if (width) {
                if ((className = getClass.call(width)) == numberClass) {
                  // Convert the `width` to an integer and create a string containing
                  // `width` number of space characters.
                  if ((width -= width % 1) > 0) {
                    for (whitespace = "", width > 10 && (width = 10); whitespace.length < width; whitespace += " ");
                  }
                } else if (className == stringClass) {
                  whitespace = width.length <= 10 ? width : width.slice(0, 10);
                }
              }
              // Opera <= 7.54u2 discards the values associated with empty string keys
              // (`""`) only if they are used directly within an object member list
              // (e.g., `!("" in { "": 1})`).
              return serialize("", (value = {}, value[""] = source, value), callback, properties, whitespace, "", []);
            };
          }
    
          // Public: Parses a JSON source string.
          if (!has("json-parse")) {
            var fromCharCode = String.fromCharCode;
    
            // Internal: A map of escaped control characters and their unescaped
            // equivalents.
            var Unescapes = {
              92: "\\",
              34: '"',
              47: "/",
              98: "\b",
              116: "\t",
              110: "\n",
              102: "\f",
              114: "\r"
            };
    
            // Internal: Stores the parser state.
            var Index, Source;
    
            // Internal: Resets the parser state and throws a `SyntaxError`.
            var abort = function () {
              Index = Source = null;
              throw SyntaxError();
            };
    
            // Internal: Returns the next token, or `"$"` if the parser has reached
            // the end of the source string. A token may be a string, number, `null`
            // literal, or Boolean literal.
            var lex = function () {
              var source = Source, length = source.length, value, begin, position, isSigned, charCode;
              while (Index < length) {
                charCode = source.charCodeAt(Index);
                switch (charCode) {
                  case 9: case 10: case 13: case 32:
                    // Skip whitespace tokens, including tabs, carriage returns, line
                    // feeds, and space characters.
                    Index++;
                    break;
                  case 123: case 125: case 91: case 93: case 58: case 44:
                    // Parse a punctuator token (`{`, `}`, `[`, `]`, `:`, or `,`) at
                    // the current position.
                    value = charIndexBuggy ? source.charAt(Index) : source[Index];
                    Index++;
                    return value;
                  case 34:
                    // `"` delimits a JSON string; advance to the next character and
                    // begin parsing the string. String tokens are prefixed with the
                    // sentinel `@` character to distinguish them from punctuators and
                    // end-of-string tokens.
                    for (value = "@", Index++; Index < length;) {
                      charCode = source.charCodeAt(Index);
                      if (charCode < 32) {
                        // Unescaped ASCII control characters (those with a code unit
                        // less than the space character) are not permitted.
                        abort();
                      } else if (charCode == 92) {
                        // A reverse solidus (`\`) marks the beginning of an escaped
                        // control character (including `"`, `\`, and `/`) or Unicode
                        // escape sequence.
                        charCode = source.charCodeAt(++Index);
                        switch (charCode) {
                          case 92: case 34: case 47: case 98: case 116: case 110: case 102: case 114:
                            // Revive escaped control characters.
                            value += Unescapes[charCode];
                            Index++;
                            break;
                          case 117:
                            // `\u` marks the beginning of a Unicode escape sequence.
                            // Advance to the first character and validate the
                            // four-digit code point.
                            begin = ++Index;
                            for (position = Index + 4; Index < position; Index++) {
                              charCode = source.charCodeAt(Index);
                              // A valid sequence comprises four hexdigits (case-
                              // insensitive) that form a single hexadecimal value.
                              if (!(charCode >= 48 && charCode <= 57 || charCode >= 97 && charCode <= 102 || charCode >= 65 && charCode <= 70)) {
                                // Invalid Unicode escape sequence.
                                abort();
                              }
                            }
                            // Revive the escaped character.
                            value += fromCharCode("0x" + source.slice(begin, Index));
                            break;
                          default:
                            // Invalid escape sequence.
                            abort();
                        }
                      } else {
                        if (charCode == 34) {
                          // An unescaped double-quote character marks the end of the
                          // string.
                          break;
                        }
                        charCode = source.charCodeAt(Index);
                        begin = Index;
                        // Optimize for the common case where a string is valid.
                        while (charCode >= 32 && charCode != 92 && charCode != 34) {
                          charCode = source.charCodeAt(++Index);
                        }
                        // Append the string as-is.
                        value += source.slice(begin, Index);
                      }
                    }
                    if (source.charCodeAt(Index) == 34) {
                      // Advance to the next character and return the revived string.
                      Index++;
                      return value;
                    }
                    // Unterminated string.
                    abort();
                  default:
                    // Parse numbers and literals.
                    begin = Index;
                    // Advance past the negative sign, if one is specified.
                    if (charCode == 45) {
                      isSigned = true;
                      charCode = source.charCodeAt(++Index);
                    }
                    // Parse an integer or floating-point value.
                    if (charCode >= 48 && charCode <= 57) {
                      // Leading zeroes are interpreted as octal literals.
                      if (charCode == 48 && ((charCode = source.charCodeAt(Index + 1)), charCode >= 48 && charCode <= 57)) {
                        // Illegal octal literal.
                        abort();
                      }
                      isSigned = false;
                      // Parse the integer component.
                      for (; Index < length && ((charCode = source.charCodeAt(Index)), charCode >= 48 && charCode <= 57); Index++);
                      // Floats cannot contain a leading decimal point; however, this
                      // case is already accounted for by the parser.
                      if (source.charCodeAt(Index) == 46) {
                        position = ++Index;
                        // Parse the decimal component.
                        for (; position < length && ((charCode = source.charCodeAt(position)), charCode >= 48 && charCode <= 57); position++);
                        if (position == Index) {
                          // Illegal trailing decimal.
                          abort();
                        }
                        Index = position;
                      }
                      // Parse exponents. The `e` denoting the exponent is
                      // case-insensitive.
                      charCode = source.charCodeAt(Index);
                      if (charCode == 101 || charCode == 69) {
                        charCode = source.charCodeAt(++Index);
                        // Skip past the sign following the exponent, if one is
                        // specified.
                        if (charCode == 43 || charCode == 45) {
                          Index++;
                        }
                        // Parse the exponential component.
                        for (position = Index; position < length && ((charCode = source.charCodeAt(position)), charCode >= 48 && charCode <= 57); position++);
                        if (position == Index) {
                          // Illegal empty exponent.
                          abort();
                        }
                        Index = position;
                      }
                      // Coerce the parsed value to a JavaScript number.
                      return +source.slice(begin, Index);
                    }
                    // A negative sign may only precede numbers.
                    if (isSigned) {
                      abort();
                    }
                    // `true`, `false`, and `null` literals.
                    if (source.slice(Index, Index + 4) == "true") {
                      Index += 4;
                      return true;
                    } else if (source.slice(Index, Index + 5) == "false") {
                      Index += 5;
                      return false;
                    } else if (source.slice(Index, Index + 4) == "null") {
                      Index += 4;
                      return null;
                    }
                    // Unrecognized token.
                    abort();
                }
              }
              // Return the sentinel `$` character if the parser has reached the end
              // of the source string.
              return "$";
            };
    
            // Internal: Parses a JSON `value` token.
            var get = function (value) {
              var results, hasMembers;
              if (value == "$") {
                // Unexpected end of input.
                abort();
              }
              if (typeof value == "string") {
                if ((charIndexBuggy ? value.charAt(0) : value[0]) == "@") {
                  // Remove the sentinel `@` character.
                  return value.slice(1);
                }
                // Parse object and array literals.
                if (value == "[") {
                  // Parses a JSON array, returning a new JavaScript array.
                  results = [];
                  for (;; hasMembers || (hasMembers = true)) {
                    value = lex();
                    // A closing square bracket marks the end of the array literal.
                    if (value == "]") {
                      break;
                    }
                    // If the array literal contains elements, the current token
                    // should be a comma separating the previous element from the
                    // next.
                    if (hasMembers) {
                      if (value == ",") {
                        value = lex();
                        if (value == "]") {
                          // Unexpected trailing `,` in array literal.
                          abort();
                        }
                      } else {
                        // A `,` must separate each array element.
                        abort();
                      }
                    }
                    // Elisions and leading commas are not permitted.
                    if (value == ",") {
                      abort();
                    }
                    results.push(get(value));
                  }
                  return results;
                } else if (value == "{") {
                  // Parses a JSON object, returning a new JavaScript object.
                  results = {};
                  for (;; hasMembers || (hasMembers = true)) {
                    value = lex();
                    // A closing curly brace marks the end of the object literal.
                    if (value == "}") {
                      break;
                    }
                    // If the object literal contains members, the current token
                    // should be a comma separator.
                    if (hasMembers) {
                      if (value == ",") {
                        value = lex();
                        if (value == "}") {
                          // Unexpected trailing `,` in object literal.
                          abort();
                        }
                      } else {
                        // A `,` must separate each object member.
                        abort();
                      }
                    }
                    // Leading commas are not permitted, object property names must be
                    // double-quoted strings, and a `:` must separate each property
                    // name and value.
                    if (value == "," || typeof value != "string" || (charIndexBuggy ? value.charAt(0) : value[0]) != "@" || lex() != ":") {
                      abort();
                    }
                    results[value.slice(1)] = get(lex());
                  }
                  return results;
                }
                // Unexpected token encountered.
                abort();
              }
              return value;
            };
    
            // Internal: Updates a traversed object member.
            var update = function (source, property, callback) {
              var element = walk(source, property, callback);
              if (element === undef) {
                delete source[property];
              } else {
                source[property] = element;
              }
            };
    
            // Internal: Recursively traverses a parsed JSON object, invoking the
            // `callback` function for each value. This is an implementation of the
            // `Walk(holder, name)` operation defined in ES 5.1 section 15.12.2.
            var walk = function (source, property, callback) {
              var value = source[property], length;
              if (typeof value == "object" && value) {
                // `forEach` can't be used to traverse an array in Opera <= 8.54
                // because its `Object#hasOwnProperty` implementation returns `false`
                // for array indices (e.g., `![1, 2, 3].hasOwnProperty("0")`).
                if (getClass.call(value) == arrayClass) {
                  for (length = value.length; length--;) {
                    update(value, length, callback);
                  }
                } else {
                  forEach(value, function (property) {
                    update(value, property, callback);
                  });
                }
              }
              return callback.call(source, property, value);
            };
    
            // Public: `JSON.parse`. See ES 5.1 section 15.12.2.
            exports.parse = function (source, callback) {
              var result, value;
              Index = 0;
              Source = "" + source;
              result = get(lex());
              // If a JSON string contains multiple tokens, it is invalid.
              if (lex() != "$") {
                abort();
              }
              // Reset the parser state.
              Index = Source = null;
              return callback && getClass.call(callback) == functionClass ? walk((value = {}, value[""] = result, value), "", callback) : result;
            };
          }
        }
    
        exports["runInContext"] = runInContext;
        return exports;
      }
    
      if (freeExports && !isLoader) {
        // Export for CommonJS environments.
        runInContext(root, freeExports);
      } else {
        // Export for web browsers and JavaScript engines.
        var nativeJSON = root.JSON,
            previousJSON = root["JSON3"],
            isRestored = false;
    
        var JSON3 = runInContext(root, (root["JSON3"] = {
          // Public: Restores the original value of the global `JSON` object and
          // returns a reference to the `JSON3` object.
          "noConflict": function () {
            if (!isRestored) {
              isRestored = true;
              root.JSON = nativeJSON;
              root["JSON3"] = previousJSON;
              nativeJSON = previousJSON = null;
            }
            return JSON3;
          }
        }));
    
        root.JSON = {
          "parse": JSON3.parse,
          "stringify": JSON3.stringify
        };
      }
    
      // Export for asynchronous module loaders.
      if (isLoader) {
        define(function () {
          return JSON3;
        });
      }
    }).call(this);
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{}],58:[function(require,module,exports){
    /**
     * Helpers.
     */
    
    var s = 1000;
    var m = s * 60;
    var h = m * 60;
    var d = h * 24;
    var y = d * 365.25;
    
    /**
     * Parse or format the given `val`.
     *
     * Options:
     *
     *  - `long` verbose formatting [false]
     *
     * @param {String|Number} val
     * @param {Object} [options]
     * @throws {Error} throw an error if val is not a non-empty string or a number
     * @return {String|Number}
     * @api public
     */
    
    module.exports = function(val, options) {
      options = options || {};
      var type = typeof val;
      if (type === 'string' && val.length > 0) {
        return parse(val);
      } else if (type === 'number' && isNaN(val) === false) {
        return options.long ? fmtLong(val) : fmtShort(val);
      }
      throw new Error(
        'val is not a non-empty string or a valid number. val=' +
          JSON.stringify(val)
      );
    };
    
    /**
     * Parse the given `str` and return milliseconds.
     *
     * @param {String} str
     * @return {Number}
     * @api private
     */
    
    function parse(str) {
      str = String(str);
      if (str.length > 100) {
        return;
      }
      var match = /^((?:\d+)?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|years?|yrs?|y)?$/i.exec(
        str
      );
      if (!match) {
        return;
      }
      var n = parseFloat(match[1]);
      var type = (match[2] || 'ms').toLowerCase();
      switch (type) {
        case 'years':
        case 'year':
        case 'yrs':
        case 'yr':
        case 'y':
          return n * y;
        case 'days':
        case 'day':
        case 'd':
          return n * d;
        case 'hours':
        case 'hour':
        case 'hrs':
        case 'hr':
        case 'h':
          return n * h;
        case 'minutes':
        case 'minute':
        case 'mins':
        case 'min':
        case 'm':
          return n * m;
        case 'seconds':
        case 'second':
        case 'secs':
        case 'sec':
        case 's':
          return n * s;
        case 'milliseconds':
        case 'millisecond':
        case 'msecs':
        case 'msec':
        case 'ms':
          return n;
        default:
          return undefined;
      }
    }
    
    /**
     * Short format for `ms`.
     *
     * @param {Number} ms
     * @return {String}
     * @api private
     */
    
    function fmtShort(ms) {
      if (ms >= d) {
        return Math.round(ms / d) + 'd';
      }
      if (ms >= h) {
        return Math.round(ms / h) + 'h';
      }
      if (ms >= m) {
        return Math.round(ms / m) + 'm';
      }
      if (ms >= s) {
        return Math.round(ms / s) + 's';
      }
      return ms + 'ms';
    }
    
    /**
     * Long format for `ms`.
     *
     * @param {Number} ms
     * @return {String}
     * @api private
     */
    
    function fmtLong(ms) {
      return plural(ms, d, 'day') ||
        plural(ms, h, 'hour') ||
        plural(ms, m, 'minute') ||
        plural(ms, s, 'second') ||
        ms + ' ms';
    }
    
    /**
     * Pluralization helper.
     */
    
    function plural(ms, n, name) {
      if (ms < n) {
        return;
      }
      if (ms < n * 1.5) {
        return Math.floor(ms / n) + ' ' + name;
      }
      return Math.ceil(ms / n) + ' ' + name + 's';
    }
    
    },{}],59:[function(require,module,exports){
    'use strict';
    
    var has = Object.prototype.hasOwnProperty;
    
    /**
     * Decode a URI encoded string.
     *
     * @param {String} input The URI encoded string.
     * @returns {String} The decoded string.
     * @api private
     */
    function decode(input) {
      return decodeURIComponent(input.replace(/\+/g, ' '));
    }
    
    /**
     * Simple query string parser.
     *
     * @param {String} query The query string that needs to be parsed.
     * @returns {Object}
     * @api public
     */
    function querystring(query) {
      var parser = /([^=?&]+)=?([^&]*)/g
        , result = {}
        , part;
    
      while (part = parser.exec(query)) {
        var key = decode(part[1])
          , value = decode(part[2]);
    
        //
        // Prevent overriding of existing properties. This ensures that build-in
        // methods like `toString` or __proto__ are not overriden by malicious
        // querystrings.
        //
        if (key in result) continue;
        result[key] = value;
      }
    
      return result;
    }
    
    /**
     * Transform a query string to an object.
     *
     * @param {Object} obj Object that should be transformed.
     * @param {String} prefix Optional prefix.
     * @returns {String}
     * @api public
     */
    function querystringify(obj, prefix) {
      prefix = prefix || '';
    
      var pairs = [];
    
      //
      // Optionally prefix with a '?' if needed
      //
      if ('string' !== typeof prefix) prefix = '?';
    
      for (var key in obj) {
        if (has.call(obj, key)) {
          pairs.push(encodeURIComponent(key) +'='+ encodeURIComponent(obj[key]));
        }
      }
    
      return pairs.length ? prefix + pairs.join('&') : '';
    }
    
    //
    // Expose the module.
    //
    exports.stringify = querystringify;
    exports.parse = querystring;
    
    },{}],60:[function(require,module,exports){
    'use strict';
    
    /**
     * Check if we're required to add a port number.
     *
     * @see https://url.spec.whatwg.org/#default-port
     * @param {Number|String} port Port number we need to check
     * @param {String} protocol Protocol we need to check against.
     * @returns {Boolean} Is it a default port for the given protocol
     * @api private
     */
    module.exports = function required(port, protocol) {
      protocol = protocol.split(':')[0];
      port = +port;
    
      if (!port) return false;
    
      switch (protocol) {
        case 'http':
        case 'ws':
        return port !== 80;
    
        case 'https':
        case 'wss':
        return port !== 443;
    
        case 'ftp':
        return port !== 21;
    
        case 'gopher':
        return port !== 70;
    
        case 'file':
        return false;
      }
    
      return port !== 0;
    };
    
    },{}],61:[function(require,module,exports){
    (function (global){
    'use strict';
    
    var required = require('requires-port')
      , qs = require('querystringify')
      , protocolre = /^([a-z][a-z0-9.+-]*:)?(\/\/)?([\S\s]*)/i
      , slashes = /^[A-Za-z][A-Za-z0-9+-.]*:\/\//;
    
    /**
     * These are the parse rules for the URL parser, it informs the parser
     * about:
     *
     * 0. The char it Needs to parse, if it's a string it should be done using
     *    indexOf, RegExp using exec and NaN means set as current value.
     * 1. The property we should set when parsing this value.
     * 2. Indication if it's backwards or forward parsing, when set as number it's
     *    the value of extra chars that should be split off.
     * 3. Inherit from location if non existing in the parser.
     * 4. `toLowerCase` the resulting value.
     */
    var rules = [
      ['#', 'hash'],                        // Extract from the back.
      ['?', 'query'],                       // Extract from the back.
      ['/', 'pathname'],                    // Extract from the back.
      ['@', 'auth', 1],                     // Extract from the front.
      [NaN, 'host', undefined, 1, 1],       // Set left over value.
      [/:(\d+)$/, 'port', undefined, 1],    // RegExp the back.
      [NaN, 'hostname', undefined, 1, 1]    // Set left over.
    ];
    
    /**
     * These properties should not be copied or inherited from. This is only needed
     * for all non blob URL's as a blob URL does not include a hash, only the
     * origin.
     *
     * @type {Object}
     * @private
     */
    var ignore = { hash: 1, query: 1 };
    
    /**
     * The location object differs when your code is loaded through a normal page,
     * Worker or through a worker using a blob. And with the blobble begins the
     * trouble as the location object will contain the URL of the blob, not the
     * location of the page where our code is loaded in. The actual origin is
     * encoded in the `pathname` so we can thankfully generate a good "default"
     * location from it so we can generate proper relative URL's again.
     *
     * @param {Object|String} loc Optional default location object.
     * @returns {Object} lolcation object.
     * @api public
     */
    function lolcation(loc) {
      loc = loc || global.location || {};
    
      var finaldestination = {}
        , type = typeof loc
        , key;
    
      if ('blob:' === loc.protocol) {
        finaldestination = new URL(unescape(loc.pathname), {});
      } else if ('string' === type) {
        finaldestination = new URL(loc, {});
        for (key in ignore) delete finaldestination[key];
      } else if ('object' === type) {
        for (key in loc) {
          if (key in ignore) continue;
          finaldestination[key] = loc[key];
        }
    
        if (finaldestination.slashes === undefined) {
          finaldestination.slashes = slashes.test(loc.href);
        }
      }
    
      return finaldestination;
    }
    
    /**
     * @typedef ProtocolExtract
     * @type Object
     * @property {String} protocol Protocol matched in the URL, in lowercase.
     * @property {Boolean} slashes `true` if protocol is followed by "//", else `false`.
     * @property {String} rest Rest of the URL that is not part of the protocol.
     */
    
    /**
     * Extract protocol information from a URL with/without double slash ("//").
     *
     * @param {String} address URL we want to extract from.
     * @return {ProtocolExtract} Extracted information.
     * @api private
     */
    function extractProtocol(address) {
      var match = protocolre.exec(address);
    
      return {
        protocol: match[1] ? match[1].toLowerCase() : '',
        slashes: !!match[2],
        rest: match[3]
      };
    }
    
    /**
     * Resolve a relative URL pathname against a base URL pathname.
     *
     * @param {String} relative Pathname of the relative URL.
     * @param {String} base Pathname of the base URL.
     * @return {String} Resolved pathname.
     * @api private
     */
    function resolve(relative, base) {
      var path = (base || '/').split('/').slice(0, -1).concat(relative.split('/'))
        , i = path.length
        , last = path[i - 1]
        , unshift = false
        , up = 0;
    
      while (i--) {
        if (path[i] === '.') {
          path.splice(i, 1);
        } else if (path[i] === '..') {
          path.splice(i, 1);
          up++;
        } else if (up) {
          if (i === 0) unshift = true;
          path.splice(i, 1);
          up--;
        }
      }
    
      if (unshift) path.unshift('');
      if (last === '.' || last === '..') path.push('');
    
      return path.join('/');
    }
    
    /**
     * The actual URL instance. Instead of returning an object we've opted-in to
     * create an actual constructor as it's much more memory efficient and
     * faster and it pleases my OCD.
     *
     * @constructor
     * @param {String} address URL we want to parse.
     * @param {Object|String} location Location defaults for relative paths.
     * @param {Boolean|Function} parser Parser for the query string.
     * @api public
     */
    function URL(address, location, parser) {
      if (!(this instanceof URL)) {
        return new URL(address, location, parser);
      }
    
      var relative, extracted, parse, instruction, index, key
        , instructions = rules.slice()
        , type = typeof location
        , url = this
        , i = 0;
    
      //
      // The following if statements allows this module two have compatibility with
      // 2 different API:
      //
      // 1. Node.js's `url.parse` api which accepts a URL, boolean as arguments
      //    where the boolean indicates that the query string should also be parsed.
      //
      // 2. The `URL` interface of the browser which accepts a URL, object as
      //    arguments. The supplied object will be used as default values / fall-back
      //    for relative paths.
      //
      if ('object' !== type && 'string' !== type) {
        parser = location;
        location = null;
      }
    
      if (parser && 'function' !== typeof parser) parser = qs.parse;
    
      location = lolcation(location);
    
      //
      // Extract protocol information before running the instructions.
      //
      extracted = extractProtocol(address || '');
      relative = !extracted.protocol && !extracted.slashes;
      url.slashes = extracted.slashes || relative && location.slashes;
      url.protocol = extracted.protocol || location.protocol || '';
      address = extracted.rest;
    
      //
      // When the authority component is absent the URL starts with a path
      // component.
      //
      if (!extracted.slashes) instructions[2] = [/(.*)/, 'pathname'];
    
      for (; i < instructions.length; i++) {
        instruction = instructions[i];
        parse = instruction[0];
        key = instruction[1];
    
        if (parse !== parse) {
          url[key] = address;
        } else if ('string' === typeof parse) {
          if (~(index = address.indexOf(parse))) {
            if ('number' === typeof instruction[2]) {
              url[key] = address.slice(0, index);
              address = address.slice(index + instruction[2]);
            } else {
              url[key] = address.slice(index);
              address = address.slice(0, index);
            }
          }
        } else if ((index = parse.exec(address))) {
          url[key] = index[1];
          address = address.slice(0, index.index);
        }
    
        url[key] = url[key] || (
          relative && instruction[3] ? location[key] || '' : ''
        );
    
        //
        // Hostname, host and protocol should be lowercased so they can be used to
        // create a proper `origin`.
        //
        if (instruction[4]) url[key] = url[key].toLowerCase();
      }
    
      //
      // Also parse the supplied query string in to an object. If we're supplied
      // with a custom parser as function use that instead of the default build-in
      // parser.
      //
      if (parser) url.query = parser(url.query);
    
      //
      // If the URL is relative, resolve the pathname against the base URL.
      //
      if (
          relative
        && location.slashes
        && url.pathname.charAt(0) !== '/'
        && (url.pathname !== '' || location.pathname !== '')
      ) {
        url.pathname = resolve(url.pathname, location.pathname);
      }
    
      //
      // We should not add port numbers if they are already the default port number
      // for a given protocol. As the host also contains the port number we're going
      // override it with the hostname which contains no port number.
      //
      if (!required(url.port, url.protocol)) {
        url.host = url.hostname;
        url.port = '';
      }
    
      //
      // Parse down the `auth` for the username and password.
      //
      url.username = url.password = '';
      if (url.auth) {
        instruction = url.auth.split(':');
        url.username = instruction[0] || '';
        url.password = instruction[1] || '';
      }
    
      url.origin = url.protocol && url.host && url.protocol !== 'file:'
        ? url.protocol +'//'+ url.host
        : 'null';
    
      //
      // The href is just the compiled result.
      //
      url.href = url.toString();
    }
    
    /**
     * This is convenience method for changing properties in the URL instance to
     * insure that they all propagate correctly.
     *
     * @param {String} part          Property we need to adjust.
     * @param {Mixed} value          The newly assigned value.
     * @param {Boolean|Function} fn  When setting the query, it will be the function
     *                               used to parse the query.
     *                               When setting the protocol, double slash will be
     *                               removed from the final url if it is true.
     * @returns {URL}
     * @api public
     */
    function set(part, value, fn) {
      var url = this;
    
      switch (part) {
        case 'query':
          if ('string' === typeof value && value.length) {
            value = (fn || qs.parse)(value);
          }
    
          url[part] = value;
          break;
    
        case 'port':
          url[part] = value;
    
          if (!required(value, url.protocol)) {
            url.host = url.hostname;
            url[part] = '';
          } else if (value) {
            url.host = url.hostname +':'+ value;
          }
    
          break;
    
        case 'hostname':
          url[part] = value;
    
          if (url.port) value += ':'+ url.port;
          url.host = value;
          break;
    
        case 'host':
          url[part] = value;
    
          if (/:\d+$/.test(value)) {
            value = value.split(':');
            url.port = value.pop();
            url.hostname = value.join(':');
          } else {
            url.hostname = value;
            url.port = '';
          }
    
          break;
    
        case 'protocol':
          url.protocol = value.toLowerCase();
          url.slashes = !fn;
          break;
    
        case 'pathname':
        case 'hash':
          if (value) {
            var char = part === 'pathname' ? '/' : '#';
            url[part] = value.charAt(0) !== char ? char + value : value;
          } else {
            url[part] = value;
          }
          break;
    
        default:
          url[part] = value;
      }
    
      for (var i = 0; i < rules.length; i++) {
        var ins = rules[i];
    
        if (ins[4]) url[ins[1]] = url[ins[1]].toLowerCase();
      }
    
      url.origin = url.protocol && url.host && url.protocol !== 'file:'
        ? url.protocol +'//'+ url.host
        : 'null';
    
      url.href = url.toString();
    
      return url;
    }
    
    /**
     * Transform the properties back in to a valid and full URL string.
     *
     * @param {Function} stringify Optional query stringify function.
     * @returns {String}
     * @api public
     */
    function toString(stringify) {
      if (!stringify || 'function' !== typeof stringify) stringify = qs.stringify;
    
      var query
        , url = this
        , protocol = url.protocol;
    
      if (protocol && protocol.charAt(protocol.length - 1) !== ':') protocol += ':';
    
      var result = protocol + (url.slashes ? '//' : '');
    
      if (url.username) {
        result += url.username;
        if (url.password) result += ':'+ url.password;
        result += '@';
      }
    
      result += url.host + url.pathname;
    
      query = 'object' === typeof url.query ? stringify(url.query) : url.query;
      if (query) result += '?' !== query.charAt(0) ? '?'+ query : query;
    
      if (url.hash) result += url.hash;
    
      return result;
    }
    
    URL.prototype = { set: set, toString: toString };
    
    //
    // Expose the URL parser and some additional properties that might be useful for
    // others or testing.
    //
    URL.extractProtocol = extractProtocol;
    URL.location = lolcation;
    URL.qs = qs;
    
    module.exports = URL;
    
    }).call(this,typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {})
    
    },{"querystringify":59,"requires-port":60}]},{},[1])(1)
    });
    
    
    //# sourceMappingURL=sockjs.js.map
    
    /* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(7)))
    
    /***/ }),
    /* 35 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    
    // The error overlay is inspired (and mostly copied) from Create React App (https://github.com/facebookincubator/create-react-app)
    // They, in turn, got inspired by webpack-hot-middleware (https://github.com/glenjamin/webpack-hot-middleware).
    
    var ansiHTML = __webpack_require__(36);
    var Entities = __webpack_require__(37).AllHtmlEntities;
    
    var entities = new Entities();
    
    var colors = {
      reset: ['transparent', 'transparent'],
      black: '181818',
      red: 'E36049',
      green: 'B3CB74',
      yellow: 'FFD080',
      blue: '7CAFC2',
      magenta: '7FACCA',
      cyan: 'C3C2EF',
      lightgrey: 'EBE7E3',
      darkgrey: '6D7891'
    };
    ansiHTML.setColors(colors);
    
    function createOverlayIframe(onIframeLoad) {
      var iframe = document.createElement('iframe');
      iframe.id = 'webpack-dev-server-client-overlay';
      iframe.src = 'about:blank';
      iframe.style.position = 'fixed';
      iframe.style.left = 0;
      iframe.style.top = 0;
      iframe.style.right = 0;
      iframe.style.bottom = 0;
      iframe.style.width = '100vw';
      iframe.style.height = '100vh';
      iframe.style.border = 'none';
      iframe.style.zIndex = 9999999999;
      iframe.onload = onIframeLoad;
      return iframe;
    }
    
    function addOverlayDivTo(iframe) {
      var div = iframe.contentDocument.createElement('div');
      div.id = 'webpack-dev-server-client-overlay-div';
      div.style.position = 'fixed';
      div.style.boxSizing = 'border-box';
      div.style.left = 0;
      div.style.top = 0;
      div.style.right = 0;
      div.style.bottom = 0;
      div.style.width = '100vw';
      div.style.height = '100vh';
      div.style.backgroundColor = 'rgba(0, 0, 0, 0.85)';
      div.style.color = '#E8E8E8';
      div.style.fontFamily = 'Menlo, Consolas, monospace';
      div.style.fontSize = 'large';
      div.style.padding = '2rem';
      div.style.lineHeight = '1.2';
      div.style.whiteSpace = 'pre-wrap';
      div.style.overflow = 'auto';
      iframe.contentDocument.body.appendChild(div);
      return div;
    }
    
    var overlayIframe = null;
    var overlayDiv = null;
    var lastOnOverlayDivReady = null;
    
    function ensureOverlayDivExists(onOverlayDivReady) {
      if (overlayDiv) {
        // Everything is ready, call the callback right away.
        onOverlayDivReady(overlayDiv);
        return;
      }
    
      // Creating an iframe may be asynchronous so we'll schedule the callback.
      // In case of multiple calls, last callback wins.
      lastOnOverlayDivReady = onOverlayDivReady;
    
      if (overlayIframe) {
        // We're already creating it.
        return;
      }
    
      // Create iframe and, when it is ready, a div inside it.
      overlayIframe = createOverlayIframe(function () {
        overlayDiv = addOverlayDivTo(overlayIframe);
        // Now we can talk!
        lastOnOverlayDivReady(overlayDiv);
      });
    
      // Zalgo alert: onIframeLoad() will be called either synchronously
      // or asynchronously depending on the browser.
      // We delay adding it so `overlayIframe` is set when `onIframeLoad` fires.
      document.body.appendChild(overlayIframe);
    }
    
    function showMessageOverlay(message) {
      ensureOverlayDivExists(function (div) {
        // Make it look similar to our terminal.
        div.innerHTML = '<span style="color: #' + colors.red + '">Failed to compile.</span><br><br>' + ansiHTML(entities.encode(message));
      });
    }
    
    function destroyErrorOverlay() {
      if (!overlayDiv) {
        // It is not there in the first place.
        return;
      }
    
      // Clean up and reset internal state.
      document.body.removeChild(overlayIframe);
      overlayDiv = null;
      overlayIframe = null;
      lastOnOverlayDivReady = null;
    }
    
    // Successful compilation.
    exports.clear = function handleSuccess() {
      destroyErrorOverlay();
    };
    
    // Compilation with errors (e.g. syntax error or missing modules).
    exports.showMessage = function handleMessage(messages) {
      showMessageOverlay(messages[0]);
    };
    
    /***/ }),
    /* 36 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    
    module.exports = ansiHTML
    
    // Reference to https://github.com/sindresorhus/ansi-regex
    var _regANSI = /(?:(?:\u001b\[)|\u009b)(?:(?:[0-9]{1,3})?(?:(?:;[0-9]{0,3})*)?[A-M|f-m])|\u001b[A-M]/
    
    var _defColors = {
      reset: ['fff', '000'], // [FOREGROUD_COLOR, BACKGROUND_COLOR]
      black: '000',
      red: 'ff0000',
      green: '209805',
      yellow: 'e8bf03',
      blue: '0000ff',
      magenta: 'ff00ff',
      cyan: '00ffee',
      lightgrey: 'f0f0f0',
      darkgrey: '888'
    }
    var _styles = {
      30: 'black',
      31: 'red',
      32: 'green',
      33: 'yellow',
      34: 'blue',
      35: 'magenta',
      36: 'cyan',
      37: 'lightgrey'
    }
    var _openTags = {
      '1': 'font-weight:bold', // bold
      '2': 'opacity:0.5', // dim
      '3': '<i>', // italic
      '4': '<u>', // underscore
      '8': 'display:none', // hidden
      '9': '<del>' // delete
    }
    var _closeTags = {
      '23': '</i>', // reset italic
      '24': '</u>', // reset underscore
      '29': '</del>' // reset delete
    }
    
    ;[0, 21, 22, 27, 28, 39, 49].forEach(function (n) {
      _closeTags[n] = '</span>'
    })
    
    /**
     * Converts text with ANSI color codes to HTML markup.
     * @param {String} text
     * @returns {*}
     */
    function ansiHTML (text) {
      // Returns the text if the string has no ANSI escape code.
      if (!_regANSI.test(text)) {
        return text
      }
    
      // Cache opened sequence.
      var ansiCodes = []
      // Replace with markup.
      var ret = text.replace(/\033\[(\d+)*m/g, function (match, seq) {
        var ot = _openTags[seq]
        if (ot) {
          // If current sequence has been opened, close it.
          if (!!~ansiCodes.indexOf(seq)) { // eslint-disable-line no-extra-boolean-cast
            ansiCodes.pop()
            return '</span>'
          }
          // Open tag.
          ansiCodes.push(seq)
          return ot[0] === '<' ? ot : '<span style="' + ot + ';">'
        }
    
        var ct = _closeTags[seq]
        if (ct) {
          // Pop sequence
          ansiCodes.pop()
          return ct
        }
        return ''
      })
    
      // Make sure tags are closed.
      var l = ansiCodes.length
      ;(l > 0) && (ret += Array(l + 1).join('</span>'))
    
      return ret
    }
    
    /**
     * Customize colors.
     * @param {Object} colors reference to _defColors
     */
    ansiHTML.setColors = function (colors) {
      if (typeof colors !== 'object') {
        throw new Error('`colors` parameter must be an Object.')
      }
    
      var _finalColors = {}
      for (var key in _defColors) {
        var hex = colors.hasOwnProperty(key) ? colors[key] : null
        if (!hex) {
          _finalColors[key] = _defColors[key]
          continue
        }
        if ('reset' === key) {
          if (typeof hex === 'string') {
            hex = [hex]
          }
          if (!Array.isArray(hex) || hex.length === 0 || hex.some(function (h) {
            return typeof h !== 'string'
          })) {
            throw new Error('The value of `' + key + '` property must be an Array and each item could only be a hex string, e.g.: FF0000')
          }
          var defHexColor = _defColors[key]
          if (!hex[0]) {
            hex[0] = defHexColor[0]
          }
          if (hex.length === 1 || !hex[1]) {
            hex = [hex[0]]
            hex.push(defHexColor[1])
          }
    
          hex = hex.slice(0, 2)
        } else if (typeof hex !== 'string') {
          throw new Error('The value of `' + key + '` property must be a hex string, e.g.: FF0000')
        }
        _finalColors[key] = hex
      }
      _setTags(_finalColors)
    }
    
    /**
     * Reset colors.
     */
    ansiHTML.reset = function () {
      _setTags(_defColors)
    }
    
    /**
     * Expose tags, including open and close.
     * @type {Object}
     */
    ansiHTML.tags = {}
    
    if (Object.defineProperty) {
      Object.defineProperty(ansiHTML.tags, 'open', {
        get: function () { return _openTags }
      })
      Object.defineProperty(ansiHTML.tags, 'close', {
        get: function () { return _closeTags }
      })
    } else {
      ansiHTML.tags.open = _openTags
      ansiHTML.tags.close = _closeTags
    }
    
    function _setTags (colors) {
      // reset all
      _openTags['0'] = 'font-weight:normal;opacity:1;color:#' + colors.reset[0] + ';background:#' + colors.reset[1]
      // inverse
      _openTags['7'] = 'color:#' + colors.reset[1] + ';background:#' + colors.reset[0]
      // dark grey
      _openTags['90'] = 'color:#' + colors.darkgrey
    
      for (var code in _styles) {
        var color = _styles[code]
        var oriColor = colors[color] || '000'
        _openTags[code] = 'color:#' + oriColor
        code = parseInt(code)
        _openTags[(code + 10).toString()] = 'background:#' + oriColor
      }
    }
    
    ansiHTML.reset()
    
    
    /***/ }),
    /* 37 */
    /***/ (function(module, exports, __webpack_require__) {
    
    module.exports = {
      XmlEntities: __webpack_require__(38),
      Html4Entities: __webpack_require__(39),
      Html5Entities: __webpack_require__(8),
      AllHtmlEntities: __webpack_require__(8)
    };
    
    
    /***/ }),
    /* 38 */
    /***/ (function(module, exports) {
    
    var ALPHA_INDEX = {
        '&lt': '<',
        '&gt': '>',
        '&quot': '"',
        '&apos': '\'',
        '&amp': '&',
        '&lt;': '<',
        '&gt;': '>',
        '&quot;': '"',
        '&apos;': '\'',
        '&amp;': '&'
    };
    
    var CHAR_INDEX = {
        60: 'lt',
        62: 'gt',
        34: 'quot',
        39: 'apos',
        38: 'amp'
    };
    
    var CHAR_S_INDEX = {
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        '\'': '&apos;',
        '&': '&amp;'
    };
    
    /**
     * @constructor
     */
    function XmlEntities() {}
    
    /**
     * @param {String} str
     * @returns {String}
     */
    XmlEntities.prototype.encode = function(str) {
        if (!str || !str.length) {
            return '';
        }
        return str.replace(/<|>|"|'|&/g, function(s) {
            return CHAR_S_INDEX[s];
        });
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
     XmlEntities.encode = function(str) {
        return new XmlEntities().encode(str);
     };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    XmlEntities.prototype.decode = function(str) {
        if (!str || !str.length) {
            return '';
        }
        return str.replace(/&#?[0-9a-zA-Z]+;?/g, function(s) {
            if (s.charAt(1) === '#') {
                var code = s.charAt(2).toLowerCase() === 'x' ?
                    parseInt(s.substr(3), 16) :
                    parseInt(s.substr(2));
    
                if (isNaN(code) || code < -32768 || code > 65535) {
                    return '';
                }
                return String.fromCharCode(code);
            }
            return ALPHA_INDEX[s] || s;
        });
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
     XmlEntities.decode = function(str) {
        return new XmlEntities().decode(str);
     };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    XmlEntities.prototype.encodeNonUTF = function(str) {
        if (!str || !str.length) {
            return '';
        }
        var strLength = str.length;
        var result = '';
        var i = 0;
        while (i < strLength) {
            var c = str.charCodeAt(i);
            var alpha = CHAR_INDEX[c];
            if (alpha) {
                result += "&" + alpha + ";";
                i++;
                continue;
            }
            if (c < 32 || c > 126) {
                result += '&#' + c + ';';
            } else {
                result += str.charAt(i);
            }
            i++;
        }
        return result;
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
     XmlEntities.encodeNonUTF = function(str) {
        return new XmlEntities().encodeNonUTF(str);
     };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    XmlEntities.prototype.encodeNonASCII = function(str) {
        if (!str || !str.length) {
            return '';
        }
        var strLenght = str.length;
        var result = '';
        var i = 0;
        while (i < strLenght) {
            var c = str.charCodeAt(i);
            if (c <= 255) {
                result += str[i++];
                continue;
            }
            result += '&#' + c + ';';
            i++;
        }
        return result;
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
     XmlEntities.encodeNonASCII = function(str) {
        return new XmlEntities().encodeNonASCII(str);
     };
    
    module.exports = XmlEntities;
    
    
    /***/ }),
    /* 39 */
    /***/ (function(module, exports) {
    
    var HTML_ALPHA = ['apos', 'nbsp', 'iexcl', 'cent', 'pound', 'curren', 'yen', 'brvbar', 'sect', 'uml', 'copy', 'ordf', 'laquo', 'not', 'shy', 'reg', 'macr', 'deg', 'plusmn', 'sup2', 'sup3', 'acute', 'micro', 'para', 'middot', 'cedil', 'sup1', 'ordm', 'raquo', 'frac14', 'frac12', 'frac34', 'iquest', 'Agrave', 'Aacute', 'Acirc', 'Atilde', 'Auml', 'Aring', 'Aelig', 'Ccedil', 'Egrave', 'Eacute', 'Ecirc', 'Euml', 'Igrave', 'Iacute', 'Icirc', 'Iuml', 'ETH', 'Ntilde', 'Ograve', 'Oacute', 'Ocirc', 'Otilde', 'Ouml', 'times', 'Oslash', 'Ugrave', 'Uacute', 'Ucirc', 'Uuml', 'Yacute', 'THORN', 'szlig', 'agrave', 'aacute', 'acirc', 'atilde', 'auml', 'aring', 'aelig', 'ccedil', 'egrave', 'eacute', 'ecirc', 'euml', 'igrave', 'iacute', 'icirc', 'iuml', 'eth', 'ntilde', 'ograve', 'oacute', 'ocirc', 'otilde', 'ouml', 'divide', 'oslash', 'ugrave', 'uacute', 'ucirc', 'uuml', 'yacute', 'thorn', 'yuml', 'quot', 'amp', 'lt', 'gt', 'OElig', 'oelig', 'Scaron', 'scaron', 'Yuml', 'circ', 'tilde', 'ensp', 'emsp', 'thinsp', 'zwnj', 'zwj', 'lrm', 'rlm', 'ndash', 'mdash', 'lsquo', 'rsquo', 'sbquo', 'ldquo', 'rdquo', 'bdquo', 'dagger', 'Dagger', 'permil', 'lsaquo', 'rsaquo', 'euro', 'fnof', 'Alpha', 'Beta', 'Gamma', 'Delta', 'Epsilon', 'Zeta', 'Eta', 'Theta', 'Iota', 'Kappa', 'Lambda', 'Mu', 'Nu', 'Xi', 'Omicron', 'Pi', 'Rho', 'Sigma', 'Tau', 'Upsilon', 'Phi', 'Chi', 'Psi', 'Omega', 'alpha', 'beta', 'gamma', 'delta', 'epsilon', 'zeta', 'eta', 'theta', 'iota', 'kappa', 'lambda', 'mu', 'nu', 'xi', 'omicron', 'pi', 'rho', 'sigmaf', 'sigma', 'tau', 'upsilon', 'phi', 'chi', 'psi', 'omega', 'thetasym', 'upsih', 'piv', 'bull', 'hellip', 'prime', 'Prime', 'oline', 'frasl', 'weierp', 'image', 'real', 'trade', 'alefsym', 'larr', 'uarr', 'rarr', 'darr', 'harr', 'crarr', 'lArr', 'uArr', 'rArr', 'dArr', 'hArr', 'forall', 'part', 'exist', 'empty', 'nabla', 'isin', 'notin', 'ni', 'prod', 'sum', 'minus', 'lowast', 'radic', 'prop', 'infin', 'ang', 'and', 'or', 'cap', 'cup', 'int', 'there4', 'sim', 'cong', 'asymp', 'ne', 'equiv', 'le', 'ge', 'sub', 'sup', 'nsub', 'sube', 'supe', 'oplus', 'otimes', 'perp', 'sdot', 'lceil', 'rceil', 'lfloor', 'rfloor', 'lang', 'rang', 'loz', 'spades', 'clubs', 'hearts', 'diams'];
    var HTML_CODES = [39, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246, 247, 248, 249, 250, 251, 252, 253, 254, 255, 34, 38, 60, 62, 338, 339, 352, 353, 376, 710, 732, 8194, 8195, 8201, 8204, 8205, 8206, 8207, 8211, 8212, 8216, 8217, 8218, 8220, 8221, 8222, 8224, 8225, 8240, 8249, 8250, 8364, 402, 913, 914, 915, 916, 917, 918, 919, 920, 921, 922, 923, 924, 925, 926, 927, 928, 929, 931, 932, 933, 934, 935, 936, 937, 945, 946, 947, 948, 949, 950, 951, 952, 953, 954, 955, 956, 957, 958, 959, 960, 961, 962, 963, 964, 965, 966, 967, 968, 969, 977, 978, 982, 8226, 8230, 8242, 8243, 8254, 8260, 8472, 8465, 8476, 8482, 8501, 8592, 8593, 8594, 8595, 8596, 8629, 8656, 8657, 8658, 8659, 8660, 8704, 8706, 8707, 8709, 8711, 8712, 8713, 8715, 8719, 8721, 8722, 8727, 8730, 8733, 8734, 8736, 8743, 8744, 8745, 8746, 8747, 8756, 8764, 8773, 8776, 8800, 8801, 8804, 8805, 8834, 8835, 8836, 8838, 8839, 8853, 8855, 8869, 8901, 8968, 8969, 8970, 8971, 9001, 9002, 9674, 9824, 9827, 9829, 9830];
    
    var alphaIndex = {};
    var numIndex = {};
    
    var i = 0;
    var length = HTML_ALPHA.length;
    while (i < length) {
        var a = HTML_ALPHA[i];
        var c = HTML_CODES[i];
        alphaIndex[a] = String.fromCharCode(c);
        numIndex[c] = a;
        i++;
    }
    
    /**
     * @constructor
     */
    function Html4Entities() {}
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html4Entities.prototype.decode = function(str) {
        if (!str || !str.length) {
            return '';
        }
        return str.replace(/&(#?[\w\d]+);?/g, function(s, entity) {
            var chr;
            if (entity.charAt(0) === "#") {
                var code = entity.charAt(1).toLowerCase() === 'x' ?
                    parseInt(entity.substr(2), 16) :
                    parseInt(entity.substr(1));
    
                if (!(isNaN(code) || code < -32768 || code > 65535)) {
                    chr = String.fromCharCode(code);
                }
            } else {
                chr = alphaIndex[entity];
            }
            return chr || s;
        });
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html4Entities.decode = function(str) {
        return new Html4Entities().decode(str);
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html4Entities.prototype.encode = function(str) {
        if (!str || !str.length) {
            return '';
        }
        var strLength = str.length;
        var result = '';
        var i = 0;
        while (i < strLength) {
            var alpha = numIndex[str.charCodeAt(i)];
            result += alpha ? "&" + alpha + ";" : str.charAt(i);
            i++;
        }
        return result;
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html4Entities.encode = function(str) {
        return new Html4Entities().encode(str);
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html4Entities.prototype.encodeNonUTF = function(str) {
        if (!str || !str.length) {
            return '';
        }
        var strLength = str.length;
        var result = '';
        var i = 0;
        while (i < strLength) {
            var cc = str.charCodeAt(i);
            var alpha = numIndex[cc];
            if (alpha) {
                result += "&" + alpha + ";";
            } else if (cc < 32 || cc > 126) {
                result += "&#" + cc + ";";
            } else {
                result += str.charAt(i);
            }
            i++;
        }
        return result;
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html4Entities.encodeNonUTF = function(str) {
        return new Html4Entities().encodeNonUTF(str);
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html4Entities.prototype.encodeNonASCII = function(str) {
        if (!str || !str.length) {
            return '';
        }
        var strLength = str.length;
        var result = '';
        var i = 0;
        while (i < strLength) {
            var c = str.charCodeAt(i);
            if (c <= 255) {
                result += str[i++];
                continue;
            }
            result += '&#' + c + ';';
            i++;
        }
        return result;
    };
    
    /**
     * @param {String} str
     * @returns {String}
     */
    Html4Entities.encodeNonASCII = function(str) {
        return new Html4Entities().encodeNonASCII(str);
    };
    
    module.exports = Html4Entities;
    
    
    /***/ }),
    /* 40 */
    /***/ (function(module, exports, __webpack_require__) {
    
    var map = {
        "./log": 41
    };
    function webpackContext(req) {
        return __webpack_require__(webpackContextResolve(req));
    };
    function webpackContextResolve(req) {
        var id = map[req];
        if(!(id + 1)) // check for number or string
            throw new Error("Cannot find module '" + req + "'.");
        return id;
    };
    webpackContext.keys = function webpackContextKeys() {
        return Object.keys(map);
    };
    webpackContext.resolve = webpackContextResolve;
    module.exports = webpackContext;
    webpackContext.id = 40;
    
    /***/ }),
    /* 41 */
    /***/ (function(module, exports) {
    
    var logLevel = "info";
    
    function dummy() {}
    
    function shouldLog(level) {
        var shouldLog = (logLevel === "info" && level === "info") ||
            (["info", "warning"].indexOf(logLevel) >= 0 && level === "warning") ||
            (["info", "warning", "error"].indexOf(logLevel) >= 0 && level === "error");
        return shouldLog;
    }
    
    function logGroup(logFn) {
        return function(level, msg) {
            if(shouldLog(level)) {
                logFn(msg);
            }
        };
    }
    
    module.exports = function(level, msg) {
        if(shouldLog(level)) {
            if(level === "info") {
                console.log(msg);
            } else if(level === "warning") {
                console.warn(msg);
            } else if(level === "error") {
                console.error(msg);
            }
        }
    };
    
    var group = console.group || dummy;
    var groupCollapsed = console.groupCollapsed || dummy;
    var groupEnd = console.groupEnd || dummy;
    
    module.exports.group = logGroup(group);
    
    module.exports.groupCollapsed = logGroup(groupCollapsed);
    
    module.exports.groupEnd = logGroup(groupEnd);
    
    module.exports.setLogLevel = function(level) {
        logLevel = level;
    };
    
    
    /***/ }),
    /* 42 */
    /***/ (function(module, exports, __webpack_require__) {
    
    var EventEmitter = __webpack_require__(43);
    module.exports = new EventEmitter();
    
    
    /***/ }),
    /* 43 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    // Copyright Joyent, Inc. and other Node contributors.
    //
    // Permission is hereby granted, free of charge, to any person obtaining a
    // copy of this software and associated documentation files (the
    // "Software"), to deal in the Software without restriction, including
    // without limitation the rights to use, copy, modify, merge, publish,
    // distribute, sublicense, and/or sell copies of the Software, and to permit
    // persons to whom the Software is furnished to do so, subject to the
    // following conditions:
    //
    // The above copyright notice and this permission notice shall be included
    // in all copies or substantial portions of the Software.
    //
    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
    // OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    // MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
    // NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
    // DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
    // OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
    // USE OR OTHER DEALINGS IN THE SOFTWARE.
    
    
    
    var R = typeof Reflect === 'object' ? Reflect : null
    var ReflectApply = R && typeof R.apply === 'function'
      ? R.apply
      : function ReflectApply(target, receiver, args) {
        return Function.prototype.apply.call(target, receiver, args);
      }
    
    var ReflectOwnKeys
    if (R && typeof R.ownKeys === 'function') {
      ReflectOwnKeys = R.ownKeys
    } else if (Object.getOwnPropertySymbols) {
      ReflectOwnKeys = function ReflectOwnKeys(target) {
        return Object.getOwnPropertyNames(target)
          .concat(Object.getOwnPropertySymbols(target));
      };
    } else {
      ReflectOwnKeys = function ReflectOwnKeys(target) {
        return Object.getOwnPropertyNames(target);
      };
    }
    
    function ProcessEmitWarning(warning) {
      if (console && console.warn) console.warn(warning);
    }
    
    var NumberIsNaN = Number.isNaN || function NumberIsNaN(value) {
      return value !== value;
    }
    
    function EventEmitter() {
      EventEmitter.init.call(this);
    }
    module.exports = EventEmitter;
    
    // Backwards-compat with node 0.10.x
    EventEmitter.EventEmitter = EventEmitter;
    
    EventEmitter.prototype._events = undefined;
    EventEmitter.prototype._eventsCount = 0;
    EventEmitter.prototype._maxListeners = undefined;
    
    // By default EventEmitters will print a warning if more than 10 listeners are
    // added to it. This is a useful default which helps finding memory leaks.
    var defaultMaxListeners = 10;
    
    function checkListener(listener) {
      if (typeof listener !== 'function') {
        throw new TypeError('The "listener" argument must be of type Function. Received type ' + typeof listener);
      }
    }
    
    Object.defineProperty(EventEmitter, 'defaultMaxListeners', {
      enumerable: true,
      get: function() {
        return defaultMaxListeners;
      },
      set: function(arg) {
        if (typeof arg !== 'number' || arg < 0 || NumberIsNaN(arg)) {
          throw new RangeError('The value of "defaultMaxListeners" is out of range. It must be a non-negative number. Received ' + arg + '.');
        }
        defaultMaxListeners = arg;
      }
    });
    
    EventEmitter.init = function() {
    
      if (this._events === undefined ||
          this._events === Object.getPrototypeOf(this)._events) {
        this._events = Object.create(null);
        this._eventsCount = 0;
      }
    
      this._maxListeners = this._maxListeners || undefined;
    };
    
    // Obviously not all Emitters should be limited to 10. This function allows
    // that to be increased. Set to zero for unlimited.
    EventEmitter.prototype.setMaxListeners = function setMaxListeners(n) {
      if (typeof n !== 'number' || n < 0 || NumberIsNaN(n)) {
        throw new RangeError('The value of "n" is out of range. It must be a non-negative number. Received ' + n + '.');
      }
      this._maxListeners = n;
      return this;
    };
    
    function _getMaxListeners(that) {
      if (that._maxListeners === undefined)
        return EventEmitter.defaultMaxListeners;
      return that._maxListeners;
    }
    
    EventEmitter.prototype.getMaxListeners = function getMaxListeners() {
      return _getMaxListeners(this);
    };
    
    EventEmitter.prototype.emit = function emit(type) {
      var args = [];
      for (var i = 1; i < arguments.length; i++) args.push(arguments[i]);
      var doError = (type === 'error');
    
      var events = this._events;
      if (events !== undefined)
        doError = (doError && events.error === undefined);
      else if (!doError)
        return false;
    
      // If there is no 'error' event listener then throw.
      if (doError) {
        var er;
        if (args.length > 0)
          er = args[0];
        if (er instanceof Error) {
          // Note: The comments on the `throw` lines are intentional, they show
          // up in Node's output if this results in an unhandled exception.
          throw er; // Unhandled 'error' event
        }
        // At least give some kind of context to the user
        var err = new Error('Unhandled error.' + (er ? ' (' + er.message + ')' : ''));
        err.context = er;
        throw err; // Unhandled 'error' event
      }
    
      var handler = events[type];
    
      if (handler === undefined)
        return false;
    
      if (typeof handler === 'function') {
        ReflectApply(handler, this, args);
      } else {
        var len = handler.length;
        var listeners = arrayClone(handler, len);
        for (var i = 0; i < len; ++i)
          ReflectApply(listeners[i], this, args);
      }
    
      return true;
    };
    
    function _addListener(target, type, listener, prepend) {
      var m;
      var events;
      var existing;
    
      checkListener(listener);
    
      events = target._events;
      if (events === undefined) {
        events = target._events = Object.create(null);
        target._eventsCount = 0;
      } else {
        // To avoid recursion in the case that type === "newListener"! Before
        // adding it to the listeners, first emit "newListener".
        if (events.newListener !== undefined) {
          target.emit('newListener', type,
                      listener.listener ? listener.listener : listener);
    
          // Re-assign `events` because a newListener handler could have caused the
          // this._events to be assigned to a new object
          events = target._events;
        }
        existing = events[type];
      }
    
      if (existing === undefined) {
        // Optimize the case of one listener. Don't need the extra array object.
        existing = events[type] = listener;
        ++target._eventsCount;
      } else {
        if (typeof existing === 'function') {
          // Adding the second element, need to change to array.
          existing = events[type] =
            prepend ? [listener, existing] : [existing, listener];
          // If we've already got an array, just append.
        } else if (prepend) {
          existing.unshift(listener);
        } else {
          existing.push(listener);
        }
    
        // Check for listener leak
        m = _getMaxListeners(target);
        if (m > 0 && existing.length > m && !existing.warned) {
          existing.warned = true;
          // No error code for this since it is a Warning
          // eslint-disable-next-line no-restricted-syntax
          var w = new Error('Possible EventEmitter memory leak detected. ' +
                              existing.length + ' ' + String(type) + ' listeners ' +
                              'added. Use emitter.setMaxListeners() to ' +
                              'increase limit');
          w.name = 'MaxListenersExceededWarning';
          w.emitter = target;
          w.type = type;
          w.count = existing.length;
          ProcessEmitWarning(w);
        }
      }
    
      return target;
    }
    
    EventEmitter.prototype.addListener = function addListener(type, listener) {
      return _addListener(this, type, listener, false);
    };
    
    EventEmitter.prototype.on = EventEmitter.prototype.addListener;
    
    EventEmitter.prototype.prependListener =
        function prependListener(type, listener) {
          return _addListener(this, type, listener, true);
        };
    
    function onceWrapper() {
      if (!this.fired) {
        this.target.removeListener(this.type, this.wrapFn);
        this.fired = true;
        if (arguments.length === 0)
          return this.listener.call(this.target);
        return this.listener.apply(this.target, arguments);
      }
    }
    
    function _onceWrap(target, type, listener) {
      var state = { fired: false, wrapFn: undefined, target: target, type: type, listener: listener };
      var wrapped = onceWrapper.bind(state);
      wrapped.listener = listener;
      state.wrapFn = wrapped;
      return wrapped;
    }
    
    EventEmitter.prototype.once = function once(type, listener) {
      checkListener(listener);
      this.on(type, _onceWrap(this, type, listener));
      return this;
    };
    
    EventEmitter.prototype.prependOnceListener =
        function prependOnceListener(type, listener) {
          checkListener(listener);
          this.prependListener(type, _onceWrap(this, type, listener));
          return this;
        };
    
    // Emits a 'removeListener' event if and only if the listener was removed.
    EventEmitter.prototype.removeListener =
        function removeListener(type, listener) {
          var list, events, position, i, originalListener;
    
          checkListener(listener);
    
          events = this._events;
          if (events === undefined)
            return this;
    
          list = events[type];
          if (list === undefined)
            return this;
    
          if (list === listener || list.listener === listener) {
            if (--this._eventsCount === 0)
              this._events = Object.create(null);
            else {
              delete events[type];
              if (events.removeListener)
                this.emit('removeListener', type, list.listener || listener);
            }
          } else if (typeof list !== 'function') {
            position = -1;
    
            for (i = list.length - 1; i >= 0; i--) {
              if (list[i] === listener || list[i].listener === listener) {
                originalListener = list[i].listener;
                position = i;
                break;
              }
            }
    
            if (position < 0)
              return this;
    
            if (position === 0)
              list.shift();
            else {
              spliceOne(list, position);
            }
    
            if (list.length === 1)
              events[type] = list[0];
    
            if (events.removeListener !== undefined)
              this.emit('removeListener', type, originalListener || listener);
          }
    
          return this;
        };
    
    EventEmitter.prototype.off = EventEmitter.prototype.removeListener;
    
    EventEmitter.prototype.removeAllListeners =
        function removeAllListeners(type) {
          var listeners, events, i;
    
          events = this._events;
          if (events === undefined)
            return this;
    
          // not listening for removeListener, no need to emit
          if (events.removeListener === undefined) {
            if (arguments.length === 0) {
              this._events = Object.create(null);
              this._eventsCount = 0;
            } else if (events[type] !== undefined) {
              if (--this._eventsCount === 0)
                this._events = Object.create(null);
              else
                delete events[type];
            }
            return this;
          }
    
          // emit removeListener for all listeners on all events
          if (arguments.length === 0) {
            var keys = Object.keys(events);
            var key;
            for (i = 0; i < keys.length; ++i) {
              key = keys[i];
              if (key === 'removeListener') continue;
              this.removeAllListeners(key);
            }
            this.removeAllListeners('removeListener');
            this._events = Object.create(null);
            this._eventsCount = 0;
            return this;
          }
    
          listeners = events[type];
    
          if (typeof listeners === 'function') {
            this.removeListener(type, listeners);
          } else if (listeners !== undefined) {
            // LIFO order
            for (i = listeners.length - 1; i >= 0; i--) {
              this.removeListener(type, listeners[i]);
            }
          }
    
          return this;
        };
    
    function _listeners(target, type, unwrap) {
      var events = target._events;
    
      if (events === undefined)
        return [];
    
      var evlistener = events[type];
      if (evlistener === undefined)
        return [];
    
      if (typeof evlistener === 'function')
        return unwrap ? [evlistener.listener || evlistener] : [evlistener];
    
      return unwrap ?
        unwrapListeners(evlistener) : arrayClone(evlistener, evlistener.length);
    }
    
    EventEmitter.prototype.listeners = function listeners(type) {
      return _listeners(this, type, true);
    };
    
    EventEmitter.prototype.rawListeners = function rawListeners(type) {
      return _listeners(this, type, false);
    };
    
    EventEmitter.listenerCount = function(emitter, type) {
      if (typeof emitter.listenerCount === 'function') {
        return emitter.listenerCount(type);
      } else {
        return listenerCount.call(emitter, type);
      }
    };
    
    EventEmitter.prototype.listenerCount = listenerCount;
    function listenerCount(type) {
      var events = this._events;
    
      if (events !== undefined) {
        var evlistener = events[type];
    
        if (typeof evlistener === 'function') {
          return 1;
        } else if (evlistener !== undefined) {
          return evlistener.length;
        }
      }
    
      return 0;
    }
    
    EventEmitter.prototype.eventNames = function eventNames() {
      return this._eventsCount > 0 ? ReflectOwnKeys(this._events) : [];
    };
    
    function arrayClone(arr, n) {
      var copy = new Array(n);
      for (var i = 0; i < n; ++i)
        copy[i] = arr[i];
      return copy;
    }
    
    function spliceOne(list, index) {
      for (; index + 1 < list.length; index++)
        list[index] = list[index + 1];
      list.pop();
    }
    
    function unwrapListeners(arr) {
      var ret = new Array(arr.length);
      for (var i = 0; i < ret.length; ++i) {
        ret[i] = arr[i].listener || arr[i];
      }
      return ret;
    }
    
    
    /***/ }),
    /* 44 */
    /***/ (function(module, exports, __webpack_require__) {
    
    "use strict";
    
    
    var _ripple = __webpack_require__(45);
    
    var _textfield = __webpack_require__(48);
    
    var _animation = __webpack_require__(64);
    
    var _icon = __webpack_require__(6);
    
    var username = new _textfield.MDCTextField(document.querySelector('.username'));
    var password = new _textfield.MDCTextField(document.querySelector('.password'));
    var eventToListenFor = (0, _animation.getCorrectEventName)(window, 'animationstart');
    
    new _ripple.MDCRipple(document.querySelector('.cancel'));
    new _ripple.MDCRipple(document.querySelector('.next'));
    
    var icon = new _icon.MDCTextFieldIcon(document.querySelector('.mdc-text-field-icon'));
    
    /***/ }),
    /* 45 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__util__ = __webpack_require__(3);
    /* harmony reexport (module object) */ __webpack_require__.d(__webpack_exports__, "util", function() { return __WEBPACK_IMPORTED_MODULE_0__util__; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__component__ = __webpack_require__(9);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCRipple", function() { return __WEBPACK_IMPORTED_MODULE_1__component__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__foundation__ = __webpack_require__(4);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCRippleFoundation", function() { return __WEBPACK_IMPORTED_MODULE_2__foundation__["a"]; });
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 46 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ponyfill__ = __webpack_require__(10);
    /* harmony reexport (module object) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__ponyfill__; });
    /**
     * @license
     * Copyright 2018 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 47 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return cssClasses; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "c", function() { return strings; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return numbers; });
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var cssClasses = {
        // Ripple is a special case where the "root" component is really a "mixin" of sorts,
        // given that it's an 'upgrade' to an existing component. That being said it is the root
        // CSS class that all other CSS classes derive from.
        BG_FOCUSED: 'mdc-ripple-upgraded--background-focused',
        FG_ACTIVATION: 'mdc-ripple-upgraded--foreground-activation',
        FG_DEACTIVATION: 'mdc-ripple-upgraded--foreground-deactivation',
        ROOT: 'mdc-ripple-upgraded',
        UNBOUNDED: 'mdc-ripple-upgraded--unbounded',
    };
    var strings = {
        VAR_FG_SCALE: '--mdc-ripple-fg-scale',
        VAR_FG_SIZE: '--mdc-ripple-fg-size',
        VAR_FG_TRANSLATE_END: '--mdc-ripple-fg-translate-end',
        VAR_FG_TRANSLATE_START: '--mdc-ripple-fg-translate-start',
        VAR_LEFT: '--mdc-ripple-left',
        VAR_TOP: '--mdc-ripple-top',
    };
    var numbers = {
        DEACTIVATION_TIMEOUT_MS: 225,
        FG_DEACTIVATION_MS: 150,
        INITIAL_ORIGIN_SCALE: 0.6,
        PADDING: 10,
        TAP_DELAY_MS: 300,
    };
    //# sourceMappingURL=constants.js.map
    
    /***/ }),
    /* 48 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__component__ = __webpack_require__(49);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextField", function() { return __WEBPACK_IMPORTED_MODULE_0__component__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__foundation__ = __webpack_require__(17);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldFoundation", function() { return __WEBPACK_IMPORTED_MODULE_1__foundation__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__character_counter_index__ = __webpack_require__(14);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldCharacterCounter", function() { return __WEBPACK_IMPORTED_MODULE_2__character_counter_index__["a"]; });
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldCharacterCounterFoundation", function() { return __WEBPACK_IMPORTED_MODULE_2__character_counter_index__["b"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__helper_text_index__ = __webpack_require__(18);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldHelperText", function() { return __WEBPACK_IMPORTED_MODULE_3__helper_text_index__["a"]; });
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldHelperTextFoundation", function() { return __WEBPACK_IMPORTED_MODULE_3__helper_text_index__["b"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__icon_index__ = __webpack_require__(6);
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldIcon", function() { return __WEBPACK_IMPORTED_MODULE_4__icon_index__["MDCTextFieldIcon"]; });
    /* harmony namespace reexport (by provided) */ __webpack_require__.d(__webpack_exports__, "MDCTextFieldIconFoundation", function() { return __WEBPACK_IMPORTED_MODULE_4__icon_index__["MDCTextFieldIconFoundation"]; });
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 49 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCTextField; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_component__ = __webpack_require__(2);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__material_dom_ponyfill__ = __webpack_require__(10);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__material_floating_label_index__ = __webpack_require__(50);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__material_line_ripple_index__ = __webpack_require__(53);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__material_notched_outline_index__ = __webpack_require__(56);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__material_ripple_component__ = __webpack_require__(9);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__material_ripple_foundation__ = __webpack_require__(4);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__character_counter_index__ = __webpack_require__(14);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__constants__ = __webpack_require__(16);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__foundation__ = __webpack_require__(17);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__helper_text_index__ = __webpack_require__(18);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_12__icon_index__ = __webpack_require__(6);
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    
    
    
    
    
    
    
    
    
    
    var MDCTextField = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCTextField, _super);
        function MDCTextField() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        MDCTextField.attachTo = function (root) {
            return new MDCTextField(root);
        };
        MDCTextField.prototype.initialize = function (rippleFactory, lineRippleFactory, helperTextFactory, characterCounterFactory, iconFactory, labelFactory, outlineFactory) {
            if (rippleFactory === void 0) { rippleFactory = function (el, foundation) { return new __WEBPACK_IMPORTED_MODULE_6__material_ripple_component__["a" /* MDCRipple */](el, foundation); }; }
            if (lineRippleFactory === void 0) { lineRippleFactory = function (el) { return new __WEBPACK_IMPORTED_MODULE_4__material_line_ripple_index__["a" /* MDCLineRipple */](el); }; }
            if (helperTextFactory === void 0) { helperTextFactory = function (el) { return new __WEBPACK_IMPORTED_MODULE_11__helper_text_index__["a" /* MDCTextFieldHelperText */](el); }; }
            if (characterCounterFactory === void 0) { characterCounterFactory = function (el) { return new __WEBPACK_IMPORTED_MODULE_8__character_counter_index__["a" /* MDCTextFieldCharacterCounter */](el); }; }
            if (iconFactory === void 0) { iconFactory = function (el) { return new __WEBPACK_IMPORTED_MODULE_12__icon_index__["MDCTextFieldIcon"](el); }; }
            if (labelFactory === void 0) { labelFactory = function (el) { return new __WEBPACK_IMPORTED_MODULE_3__material_floating_label_index__["a" /* MDCFloatingLabel */](el); }; }
            if (outlineFactory === void 0) { outlineFactory = function (el) { return new __WEBPACK_IMPORTED_MODULE_5__material_notched_outline_index__["a" /* MDCNotchedOutline */](el); }; }
            this.input_ = this.root_.querySelector(__WEBPACK_IMPORTED_MODULE_9__constants__["e" /* strings */].INPUT_SELECTOR);
            var labelElement = this.root_.querySelector(__WEBPACK_IMPORTED_MODULE_9__constants__["e" /* strings */].LABEL_SELECTOR);
            this.label_ = labelElement ? labelFactory(labelElement) : null;
            var lineRippleElement = this.root_.querySelector(__WEBPACK_IMPORTED_MODULE_9__constants__["e" /* strings */].LINE_RIPPLE_SELECTOR);
            this.lineRipple_ = lineRippleElement ? lineRippleFactory(lineRippleElement) : null;
            var outlineElement = this.root_.querySelector(__WEBPACK_IMPORTED_MODULE_9__constants__["e" /* strings */].OUTLINE_SELECTOR);
            this.outline_ = outlineElement ? outlineFactory(outlineElement) : null;
            // Helper text
            var helperTextStrings = __WEBPACK_IMPORTED_MODULE_11__helper_text_index__["b" /* MDCTextFieldHelperTextFoundation */].strings;
            var nextElementSibling = this.root_.nextElementSibling;
            var hasHelperLine = (nextElementSibling && nextElementSibling.classList.contains(__WEBPACK_IMPORTED_MODULE_9__constants__["c" /* cssClasses */].HELPER_LINE));
            var helperTextEl = hasHelperLine && nextElementSibling && nextElementSibling.querySelector(helperTextStrings.ROOT_SELECTOR);
            this.helperText_ = helperTextEl ? helperTextFactory(helperTextEl) : null;
            // Character counter
            var characterCounterStrings = __WEBPACK_IMPORTED_MODULE_8__character_counter_index__["b" /* MDCTextFieldCharacterCounterFoundation */].strings;
            var characterCounterEl = this.root_.querySelector(characterCounterStrings.ROOT_SELECTOR);
            // If character counter is not found in root element search in sibling element.
            if (!characterCounterEl && hasHelperLine && nextElementSibling) {
                characterCounterEl = nextElementSibling.querySelector(characterCounterStrings.ROOT_SELECTOR);
            }
            this.characterCounter_ = characterCounterEl ? characterCounterFactory(characterCounterEl) : null;
            this.leadingIcon_ = null;
            this.trailingIcon_ = null;
            var iconElements = this.root_.querySelectorAll(__WEBPACK_IMPORTED_MODULE_9__constants__["e" /* strings */].ICON_SELECTOR);
            if (iconElements.length > 0) {
                if (iconElements.length > 1) { // Has both icons.
                    this.leadingIcon_ = iconFactory(iconElements[0]);
                    this.trailingIcon_ = iconFactory(iconElements[1]);
                }
                else {
                    if (this.root_.classList.contains(__WEBPACK_IMPORTED_MODULE_9__constants__["c" /* cssClasses */].WITH_LEADING_ICON)) {
                        this.leadingIcon_ = iconFactory(iconElements[0]);
                    }
                    else {
                        this.trailingIcon_ = iconFactory(iconElements[0]);
                    }
                }
            }
            this.ripple = this.createRipple_(rippleFactory);
        };
        MDCTextField.prototype.destroy = function () {
            if (this.ripple) {
                this.ripple.destroy();
            }
            if (this.lineRipple_) {
                this.lineRipple_.destroy();
            }
            if (this.helperText_) {
                this.helperText_.destroy();
            }
            if (this.characterCounter_) {
                this.characterCounter_.destroy();
            }
            if (this.leadingIcon_) {
                this.leadingIcon_.destroy();
            }
            if (this.trailingIcon_) {
                this.trailingIcon_.destroy();
            }
            if (this.label_) {
                this.label_.destroy();
            }
            if (this.outline_) {
                this.outline_.destroy();
            }
            _super.prototype.destroy.call(this);
        };
        /**
         * Initializes the Text Field's internal state based on the environment's
         * state.
         */
        MDCTextField.prototype.initialSyncWithDOM = function () {
            this.disabled = this.input_.disabled;
        };
        Object.defineProperty(MDCTextField.prototype, "value", {
            get: function () {
                return this.foundation_.getValue();
            },
            /**
             * @param value The value to set on the input.
             */
            set: function (value) {
                this.foundation_.setValue(value);
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "disabled", {
            get: function () {
                return this.foundation_.isDisabled();
            },
            /**
             * @param disabled Sets the Text Field disabled or enabled.
             */
            set: function (disabled) {
                this.foundation_.setDisabled(disabled);
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "valid", {
            get: function () {
                return this.foundation_.isValid();
            },
            /**
             * @param valid Sets the Text Field valid or invalid.
             */
            set: function (valid) {
                this.foundation_.setValid(valid);
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "required", {
            get: function () {
                return this.input_.required;
            },
            /**
             * @param required Sets the Text Field to required.
             */
            set: function (required) {
                this.input_.required = required;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "pattern", {
            get: function () {
                return this.input_.pattern;
            },
            /**
             * @param pattern Sets the input element's validation pattern.
             */
            set: function (pattern) {
                this.input_.pattern = pattern;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "minLength", {
            get: function () {
                return this.input_.minLength;
            },
            /**
             * @param minLength Sets the input element's minLength.
             */
            set: function (minLength) {
                this.input_.minLength = minLength;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "maxLength", {
            get: function () {
                return this.input_.maxLength;
            },
            /**
             * @param maxLength Sets the input element's maxLength.
             */
            set: function (maxLength) {
                // Chrome throws exception if maxLength is set to a value less than zero
                if (maxLength < 0) {
                    this.input_.removeAttribute('maxLength');
                }
                else {
                    this.input_.maxLength = maxLength;
                }
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "min", {
            get: function () {
                return this.input_.min;
            },
            /**
             * @param min Sets the input element's min.
             */
            set: function (min) {
                this.input_.min = min;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "max", {
            get: function () {
                return this.input_.max;
            },
            /**
             * @param max Sets the input element's max.
             */
            set: function (max) {
                this.input_.max = max;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "step", {
            get: function () {
                return this.input_.step;
            },
            /**
             * @param step Sets the input element's step.
             */
            set: function (step) {
                this.input_.step = step;
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "helperTextContent", {
            /**
             * Sets the helper text element content.
             */
            set: function (content) {
                this.foundation_.setHelperTextContent(content);
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "leadingIconAriaLabel", {
            /**
             * Sets the aria label of the leading icon.
             */
            set: function (label) {
                this.foundation_.setLeadingIconAriaLabel(label);
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "leadingIconContent", {
            /**
             * Sets the text content of the leading icon.
             */
            set: function (content) {
                this.foundation_.setLeadingIconContent(content);
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "trailingIconAriaLabel", {
            /**
             * Sets the aria label of the trailing icon.
             */
            set: function (label) {
                this.foundation_.setTrailingIconAriaLabel(label);
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "trailingIconContent", {
            /**
             * Sets the text content of the trailing icon.
             */
            set: function (content) {
                this.foundation_.setTrailingIconContent(content);
            },
            enumerable: true,
            configurable: true
        });
        Object.defineProperty(MDCTextField.prototype, "useNativeValidation", {
            /**
             * Enables or disables the use of native validation. Use this for custom validation.
             * @param useNativeValidation Set this to false to ignore native input validation.
             */
            set: function (useNativeValidation) {
                this.foundation_.setUseNativeValidation(useNativeValidation);
            },
            enumerable: true,
            configurable: true
        });
        /**
         * Focuses the input element.
         */
        MDCTextField.prototype.focus = function () {
            this.input_.focus();
        };
        /**
         * Recomputes the outline SVG path for the outline element.
         */
        MDCTextField.prototype.layout = function () {
            var openNotch = this.foundation_.shouldFloat;
            this.foundation_.notchOutline(openNotch);
        };
        MDCTextField.prototype.getDefaultFoundation = function () {
            // DO NOT INLINE this variable. For backward compatibility, foundations take a Partial<MDCFooAdapter>.
            // To ensure we don't accidentally omit any methods, we need a separate, strongly typed adapter variable.
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            var adapter = __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, this.getRootAdapterMethods_(), this.getInputAdapterMethods_(), this.getLabelAdapterMethods_(), this.getLineRippleAdapterMethods_(), this.getOutlineAdapterMethods_());
            // tslint:enable:object-literal-sort-keys
            return new __WEBPACK_IMPORTED_MODULE_10__foundation__["a" /* MDCTextFieldFoundation */](adapter, this.getFoundationMap_());
        };
        MDCTextField.prototype.getRootAdapterMethods_ = function () {
            var _this = this;
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            return {
                addClass: function (className) { return _this.root_.classList.add(className); },
                removeClass: function (className) { return _this.root_.classList.remove(className); },
                hasClass: function (className) { return _this.root_.classList.contains(className); },
                registerTextFieldInteractionHandler: function (evtType, handler) { return _this.listen(evtType, handler); },
                deregisterTextFieldInteractionHandler: function (evtType, handler) { return _this.unlisten(evtType, handler); },
                registerValidationAttributeChangeHandler: function (handler) {
                    var getAttributesList = function (mutationsList) {
                        return mutationsList
                            .map(function (mutation) { return mutation.attributeName; })
                            .filter(function (attributeName) { return attributeName; });
                    };
                    var observer = new MutationObserver(function (mutationsList) { return handler(getAttributesList(mutationsList)); });
                    var config = { attributes: true };
                    observer.observe(_this.input_, config);
                    return observer;
                },
                deregisterValidationAttributeChangeHandler: function (observer) { return observer.disconnect(); },
            };
            // tslint:enable:object-literal-sort-keys
        };
        MDCTextField.prototype.getInputAdapterMethods_ = function () {
            var _this = this;
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            return {
                getNativeInput: function () { return _this.input_; },
                isFocused: function () { return document.activeElement === _this.input_; },
                registerInputInteractionHandler: function (evtType, handler) { return _this.input_.addEventListener(evtType, handler); },
                deregisterInputInteractionHandler: function (evtType, handler) { return _this.input_.removeEventListener(evtType, handler); },
            };
            // tslint:enable:object-literal-sort-keys
        };
        MDCTextField.prototype.getLabelAdapterMethods_ = function () {
            var _this = this;
            return {
                floatLabel: function (shouldFloat) { return _this.label_ && _this.label_.float(shouldFloat); },
                getLabelWidth: function () { return _this.label_ ? _this.label_.getWidth() : 0; },
                hasLabel: function () { return Boolean(_this.label_); },
                shakeLabel: function (shouldShake) { return _this.label_ && _this.label_.shake(shouldShake); },
            };
        };
        MDCTextField.prototype.getLineRippleAdapterMethods_ = function () {
            var _this = this;
            return {
                activateLineRipple: function () {
                    if (_this.lineRipple_) {
                        _this.lineRipple_.activate();
                    }
                },
                deactivateLineRipple: function () {
                    if (_this.lineRipple_) {
                        _this.lineRipple_.deactivate();
                    }
                },
                setLineRippleTransformOrigin: function (normalizedX) {
                    if (_this.lineRipple_) {
                        _this.lineRipple_.setRippleCenter(normalizedX);
                    }
                },
            };
        };
        MDCTextField.prototype.getOutlineAdapterMethods_ = function () {
            var _this = this;
            return {
                closeOutline: function () { return _this.outline_ && _this.outline_.closeNotch(); },
                hasOutline: function () { return Boolean(_this.outline_); },
                notchOutline: function (labelWidth) { return _this.outline_ && _this.outline_.notch(labelWidth); },
            };
        };
        /**
         * @return A map of all subcomponents to subfoundations.
         */
        MDCTextField.prototype.getFoundationMap_ = function () {
            return {
                characterCounter: this.characterCounter_ ? this.characterCounter_.foundation : undefined,
                helperText: this.helperText_ ? this.helperText_.foundation : undefined,
                leadingIcon: this.leadingIcon_ ? this.leadingIcon_.foundation : undefined,
                trailingIcon: this.trailingIcon_ ? this.trailingIcon_.foundation : undefined,
            };
        };
        MDCTextField.prototype.createRipple_ = function (rippleFactory) {
            var _this = this;
            var isTextArea = this.root_.classList.contains(__WEBPACK_IMPORTED_MODULE_9__constants__["c" /* cssClasses */].TEXTAREA);
            var isOutlined = this.root_.classList.contains(__WEBPACK_IMPORTED_MODULE_9__constants__["c" /* cssClasses */].OUTLINED);
            if (isTextArea || isOutlined) {
                return null;
            }
            // DO NOT INLINE this variable. For backward compatibility, foundations take a Partial<MDCFooAdapter>.
            // To ensure we don't accidentally omit any methods, we need a separate, strongly typed adapter variable.
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            var adapter = __WEBPACK_IMPORTED_MODULE_0_tslib__["a" /* __assign */]({}, __WEBPACK_IMPORTED_MODULE_6__material_ripple_component__["a" /* MDCRipple */].createAdapter(this), { isSurfaceActive: function () { return __WEBPACK_IMPORTED_MODULE_2__material_dom_ponyfill__["matches"](_this.input_, ':active'); }, registerInteractionHandler: function (evtType, handler) { return _this.input_.addEventListener(evtType, handler); }, deregisterInteractionHandler: function (evtType, handler) { return _this.input_.removeEventListener(evtType, handler); } });
            // tslint:enable:object-literal-sort-keys
            return rippleFactory(this.root_, new __WEBPACK_IMPORTED_MODULE_7__material_ripple_foundation__["a" /* MDCRippleFoundation */](adapter));
        };
        return MDCTextField;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_component__["a" /* MDCComponent */]));
    
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 50 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__component__ = __webpack_require__(51);
    /* harmony namespace reexport (by used) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__component__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__foundation__ = __webpack_require__(5);
    /* unused harmony namespace reexport */
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 51 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCFloatingLabel; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_component__ = __webpack_require__(2);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__foundation__ = __webpack_require__(5);
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCFloatingLabel = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCFloatingLabel, _super);
        function MDCFloatingLabel() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        MDCFloatingLabel.attachTo = function (root) {
            return new MDCFloatingLabel(root);
        };
        /**
         * Styles the label to produce the label shake for errors.
         * @param shouldShake If true, shakes the label by adding a CSS class; otherwise, stops shaking by removing the class.
         */
        MDCFloatingLabel.prototype.shake = function (shouldShake) {
            this.foundation_.shake(shouldShake);
        };
        /**
         * Styles the label to float/dock.
         * @param shouldFloat If true, floats the label by adding a CSS class; otherwise, docks it by removing the class.
         */
        MDCFloatingLabel.prototype.float = function (shouldFloat) {
            this.foundation_.float(shouldFloat);
        };
        MDCFloatingLabel.prototype.getWidth = function () {
            return this.foundation_.getWidth();
        };
        MDCFloatingLabel.prototype.getDefaultFoundation = function () {
            var _this = this;
            // DO NOT INLINE this variable. For backward compatibility, foundations take a Partial<MDCFooAdapter>.
            // To ensure we don't accidentally omit any methods, we need a separate, strongly typed adapter variable.
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            var adapter = {
                addClass: function (className) { return _this.root_.classList.add(className); },
                removeClass: function (className) { return _this.root_.classList.remove(className); },
                getWidth: function () { return _this.root_.scrollWidth; },
                registerInteractionHandler: function (evtType, handler) { return _this.listen(evtType, handler); },
                deregisterInteractionHandler: function (evtType, handler) { return _this.unlisten(evtType, handler); },
            };
            // tslint:enable:object-literal-sort-keys
            return new __WEBPACK_IMPORTED_MODULE_2__foundation__["a" /* MDCFloatingLabelFoundation */](adapter);
        };
        return MDCFloatingLabel;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_component__["a" /* MDCComponent */]));
    
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 52 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return cssClasses; });
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var cssClasses = {
        LABEL_FLOAT_ABOVE: 'mdc-floating-label--float-above',
        LABEL_SHAKE: 'mdc-floating-label--shake',
        ROOT: 'mdc-floating-label',
    };
    //# sourceMappingURL=constants.js.map
    
    /***/ }),
    /* 53 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__component__ = __webpack_require__(54);
    /* harmony namespace reexport (by used) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__component__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__foundation__ = __webpack_require__(11);
    /* unused harmony namespace reexport */
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 54 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCLineRipple; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_component__ = __webpack_require__(2);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__foundation__ = __webpack_require__(11);
    /**
     * @license
     * Copyright 2018 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCLineRipple = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCLineRipple, _super);
        function MDCLineRipple() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        MDCLineRipple.attachTo = function (root) {
            return new MDCLineRipple(root);
        };
        /**
         * Activates the line ripple
         */
        MDCLineRipple.prototype.activate = function () {
            this.foundation_.activate();
        };
        /**
         * Deactivates the line ripple
         */
        MDCLineRipple.prototype.deactivate = function () {
            this.foundation_.deactivate();
        };
        /**
         * Sets the transform origin given a user's click location.
         * The `rippleCenter` is the x-coordinate of the middle of the ripple.
         */
        MDCLineRipple.prototype.setRippleCenter = function (xCoordinate) {
            this.foundation_.setRippleCenter(xCoordinate);
        };
        MDCLineRipple.prototype.getDefaultFoundation = function () {
            var _this = this;
            // DO NOT INLINE this variable. For backward compatibility, foundations take a Partial<MDCFooAdapter>.
            // To ensure we don't accidentally omit any methods, we need a separate, strongly typed adapter variable.
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            var adapter = {
                addClass: function (className) { return _this.root_.classList.add(className); },
                removeClass: function (className) { return _this.root_.classList.remove(className); },
                hasClass: function (className) { return _this.root_.classList.contains(className); },
                setStyle: function (propertyName, value) { return _this.root_.style.setProperty(propertyName, value); },
                registerEventHandler: function (evtType, handler) { return _this.listen(evtType, handler); },
                deregisterEventHandler: function (evtType, handler) { return _this.unlisten(evtType, handler); },
            };
            // tslint:enable:object-literal-sort-keys
            return new __WEBPACK_IMPORTED_MODULE_2__foundation__["a" /* MDCLineRippleFoundation */](adapter);
        };
        return MDCLineRipple;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_component__["a" /* MDCComponent */]));
    
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 55 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return cssClasses; });
    /**
     * @license
     * Copyright 2018 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var cssClasses = {
        LINE_RIPPLE_ACTIVE: 'mdc-line-ripple--active',
        LINE_RIPPLE_DEACTIVATING: 'mdc-line-ripple--deactivating',
    };
    
    //# sourceMappingURL=constants.js.map
    
    /***/ }),
    /* 56 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__component__ = __webpack_require__(57);
    /* harmony namespace reexport (by used) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_0__component__["a"]; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__foundation__ = __webpack_require__(13);
    /* unused harmony namespace reexport */
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    //# sourceMappingURL=index.js.map
    
    /***/ }),
    /* 57 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCNotchedOutline; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_component__ = __webpack_require__(2);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__material_floating_label_foundation__ = __webpack_require__(5);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__constants__ = __webpack_require__(12);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__foundation__ = __webpack_require__(13);
    /**
     * @license
     * Copyright 2017 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    
    
    var MDCNotchedOutline = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCNotchedOutline, _super);
        function MDCNotchedOutline() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        MDCNotchedOutline.attachTo = function (root) {
            return new MDCNotchedOutline(root);
        };
        MDCNotchedOutline.prototype.initialSyncWithDOM = function () {
            this.notchElement_ = this.root_.querySelector(__WEBPACK_IMPORTED_MODULE_3__constants__["c" /* strings */].NOTCH_ELEMENT_SELECTOR);
            var label = this.root_.querySelector('.' + __WEBPACK_IMPORTED_MODULE_2__material_floating_label_foundation__["a" /* MDCFloatingLabelFoundation */].cssClasses.ROOT);
            if (label) {
                label.style.transitionDuration = '0s';
                this.root_.classList.add(__WEBPACK_IMPORTED_MODULE_3__constants__["a" /* cssClasses */].OUTLINE_UPGRADED);
                requestAnimationFrame(function () {
                    label.style.transitionDuration = '';
                });
            }
            else {
                this.root_.classList.add(__WEBPACK_IMPORTED_MODULE_3__constants__["a" /* cssClasses */].NO_LABEL);
            }
        };
        /**
         * Updates classes and styles to open the notch to the specified width.
         * @param notchWidth The notch width in the outline.
         */
        MDCNotchedOutline.prototype.notch = function (notchWidth) {
            this.foundation_.notch(notchWidth);
        };
        /**
         * Updates classes and styles to close the notch.
         */
        MDCNotchedOutline.prototype.closeNotch = function () {
            this.foundation_.closeNotch();
        };
        MDCNotchedOutline.prototype.getDefaultFoundation = function () {
            var _this = this;
            // DO NOT INLINE this variable. For backward compatibility, foundations take a Partial<MDCFooAdapter>.
            // To ensure we don't accidentally omit any methods, we need a separate, strongly typed adapter variable.
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            var adapter = {
                addClass: function (className) { return _this.root_.classList.add(className); },
                removeClass: function (className) { return _this.root_.classList.remove(className); },
                setNotchWidthProperty: function (width) { return _this.notchElement_.style.setProperty('width', width + 'px'); },
                removeNotchWidthProperty: function () { return _this.notchElement_.style.removeProperty('width'); },
            };
            // tslint:enable:object-literal-sort-keys
            return new __WEBPACK_IMPORTED_MODULE_4__foundation__["a" /* MDCNotchedOutlineFoundation */](adapter);
        };
        return MDCNotchedOutline;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_component__["a" /* MDCComponent */]));
    
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 58 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCTextFieldCharacterCounter; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_component__ = __webpack_require__(2);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__foundation__ = __webpack_require__(15);
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCTextFieldCharacterCounter = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCTextFieldCharacterCounter, _super);
        function MDCTextFieldCharacterCounter() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        MDCTextFieldCharacterCounter.attachTo = function (root) {
            return new MDCTextFieldCharacterCounter(root);
        };
        Object.defineProperty(MDCTextFieldCharacterCounter.prototype, "foundation", {
            get: function () {
                return this.foundation_;
            },
            enumerable: true,
            configurable: true
        });
        MDCTextFieldCharacterCounter.prototype.getDefaultFoundation = function () {
            var _this = this;
            // DO NOT INLINE this variable. For backward compatibility, foundations take a Partial<MDCFooAdapter>.
            // To ensure we don't accidentally omit any methods, we need a separate, strongly typed adapter variable.
            var adapter = {
                setContent: function (content) {
                    _this.root_.textContent = content;
                },
            };
            return new __WEBPACK_IMPORTED_MODULE_2__foundation__["a" /* MDCTextFieldCharacterCounterFoundation */](adapter);
        };
        return MDCTextFieldCharacterCounter;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_component__["a" /* MDCComponent */]));
    
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 59 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return strings; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return cssClasses; });
    /**
     * @license
     * Copyright 2019 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var cssClasses = {
        ROOT: 'mdc-text-field-character-counter',
    };
    var strings = {
        ROOT_SELECTOR: "." + cssClasses.ROOT,
    };
    
    //# sourceMappingURL=constants.js.map
    
    /***/ }),
    /* 60 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCTextFieldHelperText; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_component__ = __webpack_require__(2);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__foundation__ = __webpack_require__(19);
    /**
     * @license
     * Copyright 2017 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCTextFieldHelperText = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCTextFieldHelperText, _super);
        function MDCTextFieldHelperText() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        MDCTextFieldHelperText.attachTo = function (root) {
            return new MDCTextFieldHelperText(root);
        };
        Object.defineProperty(MDCTextFieldHelperText.prototype, "foundation", {
            get: function () {
                return this.foundation_;
            },
            enumerable: true,
            configurable: true
        });
        MDCTextFieldHelperText.prototype.getDefaultFoundation = function () {
            var _this = this;
            // DO NOT INLINE this variable. For backward compatibility, foundations take a Partial<MDCFooAdapter>.
            // To ensure we don't accidentally omit any methods, we need a separate, strongly typed adapter variable.
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            var adapter = {
                addClass: function (className) { return _this.root_.classList.add(className); },
                removeClass: function (className) { return _this.root_.classList.remove(className); },
                hasClass: function (className) { return _this.root_.classList.contains(className); },
                setAttr: function (attr, value) { return _this.root_.setAttribute(attr, value); },
                removeAttr: function (attr) { return _this.root_.removeAttribute(attr); },
                setContent: function (content) {
                    _this.root_.textContent = content;
                },
            };
            // tslint:enable:object-literal-sort-keys
            return new __WEBPACK_IMPORTED_MODULE_2__foundation__["a" /* MDCTextFieldHelperTextFoundation */](adapter);
        };
        return MDCTextFieldHelperText;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_component__["a" /* MDCComponent */]));
    
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 61 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return strings; });
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return cssClasses; });
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var cssClasses = {
        HELPER_TEXT_PERSISTENT: 'mdc-text-field-helper-text--persistent',
        HELPER_TEXT_VALIDATION_MSG: 'mdc-text-field-helper-text--validation-msg',
        ROOT: 'mdc-text-field-helper-text',
    };
    var strings = {
        ARIA_HIDDEN: 'aria-hidden',
        ROLE: 'role',
        ROOT_SELECTOR: "." + cssClasses.ROOT,
    };
    
    //# sourceMappingURL=constants.js.map
    
    /***/ }),
    /* 62 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MDCTextFieldIcon; });
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_tslib__ = __webpack_require__(0);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__material_base_component__ = __webpack_require__(2);
    /* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__foundation__ = __webpack_require__(20);
    /**
     * @license
     * Copyright 2017 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    
    
    
    var MDCTextFieldIcon = /** @class */ (function (_super) {
        __WEBPACK_IMPORTED_MODULE_0_tslib__["b" /* __extends */](MDCTextFieldIcon, _super);
        function MDCTextFieldIcon() {
            return _super !== null && _super.apply(this, arguments) || this;
        }
        MDCTextFieldIcon.attachTo = function (root) {
            return new MDCTextFieldIcon(root);
        };
        Object.defineProperty(MDCTextFieldIcon.prototype, "foundation", {
            get: function () {
                return this.foundation_;
            },
            enumerable: true,
            configurable: true
        });
        MDCTextFieldIcon.prototype.getDefaultFoundation = function () {
            var _this = this;
            // DO NOT INLINE this variable. For backward compatibility, foundations take a Partial<MDCFooAdapter>.
            // To ensure we don't accidentally omit any methods, we need a separate, strongly typed adapter variable.
            // tslint:disable:object-literal-sort-keys Methods should be in the same order as the adapter interface.
            var adapter = {
                getAttr: function (attr) { return _this.root_.getAttribute(attr); },
                setAttr: function (attr, value) { return _this.root_.setAttribute(attr, value); },
                removeAttr: function (attr) { return _this.root_.removeAttribute(attr); },
                setContent: function (content) {
                    _this.root_.textContent = content;
                },
                registerInteractionHandler: function (evtType, handler) { return _this.listen(evtType, handler); },
                deregisterInteractionHandler: function (evtType, handler) { return _this.unlisten(evtType, handler); },
                notifyIconAction: function () { return _this.emit(__WEBPACK_IMPORTED_MODULE_2__foundation__["a" /* MDCTextFieldIconFoundation */].strings.ICON_EVENT, {} /* evtData */, true /* shouldBubble */); },
            };
            // tslint:enable:object-literal-sort-keys
            return new __WEBPACK_IMPORTED_MODULE_2__foundation__["a" /* MDCTextFieldIconFoundation */](adapter);
        };
        return MDCTextFieldIcon;
    }(__WEBPACK_IMPORTED_MODULE_1__material_base_component__["a" /* MDCComponent */]));
    
    //# sourceMappingURL=component.js.map
    
    /***/ }),
    /* 63 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    /* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return strings; });
    /**
     * @license
     * Copyright 2016 Google Inc.
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
     */
    var strings = {
        ICON_EVENT: 'MDCTextField:icon',
        ICON_ROLE: 'button',
    };
    
    //# sourceMappingURL=constants.js.map
    
    /***/ }),
    /* 64 */
    /***/ (function(module, __webpack_exports__, __webpack_require__) {
    
    "use strict";
    Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
    /* harmony export (immutable) */ __webpack_exports__["getCorrectEventName"] = getCorrectEventName;
    /* harmony export (immutable) */ __webpack_exports__["getCorrectPropertyName"] = getCorrectPropertyName;
    /**
     * Copyright 2016 Google Inc. All Rights Reserved.
     *
     * Licensed under the Apache License, Version 2.0 (the "License");
     * you may not use this file except in compliance with the License.
     * You may obtain a copy of the License at
     *
     *      http://www.apache.org/licenses/LICENSE-2.0
     *
     * Unless required by applicable law or agreed to in writing, software
     * distributed under the License is distributed on an "AS IS" BASIS,
     * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     * See the License for the specific language governing permissions and
     * limitations under the License.
     */
    
    /**
     * @typedef {{
     *   noPrefix: string,
     *   webkitPrefix: string
     * }}
     */
    let VendorPropertyMapType;
    
    /** @const {Object<string, !VendorPropertyMapType>} */
    const eventTypeMap = {
      'animationstart': {
        noPrefix: 'animationstart',
        webkitPrefix: 'webkitAnimationStart',
        styleProperty: 'animation',
      },
      'animationend': {
        noPrefix: 'animationend',
        webkitPrefix: 'webkitAnimationEnd',
        styleProperty: 'animation',
      },
      'animationiteration': {
        noPrefix: 'animationiteration',
        webkitPrefix: 'webkitAnimationIteration',
        styleProperty: 'animation',
      },
      'transitionend': {
        noPrefix: 'transitionend',
        webkitPrefix: 'webkitTransitionEnd',
        styleProperty: 'transition',
      },
    };
    
    /** @const {Object<string, !VendorPropertyMapType>} */
    const cssPropertyMap = {
      'animation': {
        noPrefix: 'animation',
        webkitPrefix: '-webkit-animation',
      },
      'transform': {
        noPrefix: 'transform',
        webkitPrefix: '-webkit-transform',
      },
      'transition': {
        noPrefix: 'transition',
        webkitPrefix: '-webkit-transition',
      },
    };
    
    /**
     * @param {!Object} windowObj
     * @return {boolean}
     */
    function hasProperShape(windowObj) {
      return (windowObj['document'] !== undefined && typeof windowObj['document']['createElement'] === 'function');
    }
    
    /**
     * @param {string} eventType
     * @return {boolean}
     */
    function eventFoundInMaps(eventType) {
      return (eventType in eventTypeMap || eventType in cssPropertyMap);
    }
    
    /**
     * @param {string} eventType
     * @param {!Object<string, !VendorPropertyMapType>} map
     * @param {!Element} el
     * @return {string}
     */
    function getJavaScriptEventName(eventType, map, el) {
      return map[eventType].styleProperty in el.style ? map[eventType].noPrefix : map[eventType].webkitPrefix;
    }
    
    /**
     * Helper function to determine browser prefix for CSS3 animation events
     * and property names.
     * @param {!Object} windowObj
     * @param {string} eventType
     * @return {string}
     */
    function getAnimationName(windowObj, eventType) {
      if (!hasProperShape(windowObj) || !eventFoundInMaps(eventType)) {
        return eventType;
      }
    
      const map = /** @type {!Object<string, !VendorPropertyMapType>} */ (
        eventType in eventTypeMap ? eventTypeMap : cssPropertyMap
      );
      const el = windowObj['document']['createElement']('div');
      let eventName = '';
    
      if (map === eventTypeMap) {
        eventName = getJavaScriptEventName(eventType, map, el);
      } else {
        eventName = map[eventType].noPrefix in el.style ? map[eventType].noPrefix : map[eventType].webkitPrefix;
      }
    
      return eventName;
    }
    
    // Public functions to access getAnimationName() for JavaScript events or CSS
    // property names.
    
    const transformStyleProperties = ['transform', 'WebkitTransform', 'MozTransform', 'OTransform', 'MSTransform'];
    /* harmony export (immutable) */ __webpack_exports__["transformStyleProperties"] = transformStyleProperties;
    
    
    /**
     * @param {!Object} windowObj
     * @param {string} eventType
     * @return {string}
     */
    function getCorrectEventName(windowObj, eventType) {
      return getAnimationName(windowObj, eventType);
    }
    
    /**
     * @param {!Object} windowObj
     * @param {string} eventType
     * @return {string}
     */
    function getCorrectPropertyName(windowObj, eventType) {
      return getAnimationName(windowObj, eventType);
    }
    
    
    /***/ })
    /******/ ]);