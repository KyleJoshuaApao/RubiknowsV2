import os
import re

admin_dir = r"c:\Users\kylej_z264ll1\RubiknowsV2\resources\views\admin"

replacements = [
    (r'font-semibold text-2xl text-gray-900 leading-tight font-display text-2xl tracking-tight', r'font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight'),
    (r'font-semibold text-2xl text-gray-900 leading-tight', r'font-black text-3xl uppercase tracking-tighter text-richblack-900 leading-tight'),
    (r'text-sm text-gray-500 mt-1', r'text-sm font-bold uppercase tracking-widest text-gray-500 mt-2'),
    (r'inline-flex items-center bg-brand-500 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-brand-600 hover:shadow transition-all duration-200 font-medium text-sm', r'inline-flex items-center bg-brand-500 text-white px-6 py-3 font-bold uppercase tracking-widest text-xs hover:bg-brand-600 transition-colors'),
    (r'inline-flex items-center px-4 py-2 bg-brand-500 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm', r'inline-flex items-center bg-brand-500 text-white px-6 py-3 font-bold uppercase tracking-widest text-xs hover:bg-brand-600 transition-colors'),
    (r'inline-flex items-center px-4 py-1.5 bg-brand-500 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors shadow-sm', r'inline-flex items-center bg-brand-500 text-white px-6 py-3 font-bold uppercase tracking-widest text-xs hover:bg-brand-600 transition-colors'),
    (r'bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-6', r'bg-white border-t-4 border-brand-500 border-b border-x border-gray-200 mt-8'),
    (r'bg-white  shadow-sm border border-gray-100 overflow-hidden mt-6', r'bg-white border-t-4 border-brand-500 border-b border-x border-gray-200 mt-8'),
    (r'mt-6 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden', r'mt-8 bg-white border-t-4 border-brand-500 border-b border-x border-gray-200 overflow-hidden'),
    (r'bg-white shadow-sm sm:rounded-lg p-6', r'bg-white border-t-4 border-brand-500 p-8 shadow-sm'),
    (r'bg-gray-50/80', r'bg-gray-50'),
    (r'px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider', r'px-8 py-5 text-left text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200'),
    (r'px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider', r'px-8 py-5 text-right text-xs font-black text-richblack-900 uppercase tracking-widest border-b border-gray-200'),
    (r'hover:bg-gray-50/50 transition-colors duration-150 group', r'hover:bg-gray-50 transition-colors duration-150 group'),
    (r'px-6 py-4 whitespace-nowrap', r'px-8 py-6 whitespace-nowrap'),
    (r'text-sm font-medium text-gray-900', r'text-base font-black text-richblack-900 uppercase tracking-widest'),
    (r'px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium text-sm transition-all', r'px-6 py-3 border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-bold uppercase tracking-widest text-xs transition-colors'),
    (r'bg-brand-500 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-brand-600 font-medium text-sm transition-all duration-200', r'bg-brand-500 text-white px-6 py-3 shadow-sm hover:bg-brand-600 font-bold uppercase tracking-widest text-xs transition-colors'),
    (r'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors shadow-sm', r'inline-flex items-center px-6 py-3 bg-white border-2 border-gray-200 font-bold uppercase tracking-widest text-xs text-gray-700 hover:bg-gray-50 transition-colors'),
    (r'mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm', r'block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors'),
    (r'\b(sm:)?rounded-(xl|lg|md|2xl|3xl|full)\b', r''),
]

for root, dirs, files in os.walk(admin_dir):
    for file in files:
        if file.endswith('.blade.php'):
            path = os.path.join(root, file)
            with open(path, 'r', encoding='utf-8') as f:
                content = f.read()
            
            orig = content
            for pattern, repl in replacements:
                content = re.sub(pattern, repl, content)
                
            if orig != content:
                with open(path, 'w', encoding='utf-8') as f:
                    f.write(content)
                print(f"Updated {file}")
print("Done")
