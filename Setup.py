#
# setup.py for testdox.py application ( Python 2.6, 3.0 )
#
# Generate a readable overview of test case names from the specified files.
#
# Inspired on TestDox by Chris Stevenson, see
# http://skizz.biz/blog/2003/06/17/testdox-release-01/
#
# Author: Martin Moene, http://www.eld.leidenuniv.nl/~moene/
#
# This tool is provided under the Boost license.  Please read
# http://www.boost.org/users/license.html for the original text.
#
# $Id$
#

#
# Usage: python Setup.py install
#

from distutils.core import setup

from testdox import versionString, versionState

setup(      name = 'TestDox',
         version = versionString() + '-' + versionState(),
     description = 'Generate a readable overview of test case names from the specified files',
          author = 'Martin Moene',
    author_email = 'm.j.moene@eld.physics.LeidenUniv.nl',
             url = 'http://www.eld.leidenuniv.nl/~moene/Home/projects/testdox/',
      py_modules = ['testdox'],
         license = 'Boost 1.0',
       platforms = ['i386-Win32'],
long_description = """Long descr.""",
)

#
# end of file
#
