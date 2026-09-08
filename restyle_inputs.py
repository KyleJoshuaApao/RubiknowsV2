import os
import re

admin_dir = r"c:\Users\kylej_z264ll1\RubiknowsV2\resources\views\admin"

replacements = [
    (r'w-full px-4 py-3  border border-gray-200 focus:border-\[\#E07B2A\] focus:ring-1 focus:ring-\[\#E07B2A\] transition-all text-sm', r'block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors'),
    (r'w-full px-4 py-3 border border-gray-200 focus:border-\[\#E07B2A\] focus:ring-1 focus:ring-\[\#E07B2A\] transition-all text-sm', r'block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors'),
    (r'px-4 py-2  border border-gray-200 text-gray-700 hover:bg-gray-50 font-medium text-sm transition-all', r'px-6 py-3 border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-bold uppercase tracking-widest text-xs transition-colors'),
    (r'bg-brand-500 text-white px-4 py-2  shadow-sm hover:bg-brand-600 font-medium text-sm transition-all duration-200', r'bg-brand-500 text-white px-6 py-3 shadow-sm hover:bg-brand-600 font-bold uppercase tracking-widest text-xs transition-colors'),
    (r'mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500 rounded-md shadow-sm', r'block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors'),
    (r'mt-1 block w-full border-gray-300 focus:border-orange-500 focus:ring-orange-500  shadow-sm', r'block w-full bg-gray-50 border-0 border-b-4 border-gray-200 focus:border-brand-500 focus:ring-0 px-4 py-4 font-bold text-gray-900 transition-colors'),
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
                print(f"Updated inputs in {file}")
print("Done")
