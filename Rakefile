namespace :jekyll do

  desc 'Delete generated _site files'
  task :clean do
    system "rm -fR _site"
  end

  desc 'Run the jekyll dev server'
  task :server do
    system "jekyll --server --auto --no-lsi"
  end

  desc 'Clean temporary files and run the server'
  task :compile => [:clean] do
    system "jekyll"
  end

end

namespace :pygments do

  desc 'Delete pygments CSS files'
  task :clean do
    system "rm -f i/pygments/*.css"
  end

  desc 'Generate pygments CSS'
  task :compile => [:clean] do
    system "mkdir -p _sass/3rd_party/pygments"
    system "pygmentize -S default -f html > i/pygments/default.css"
  end

end

namespace :dev do

  desc 'Un-publish old posts to speed up development'
  task :on => ['jekyll:clean'] do
    system 'find . -name "*.textile" -exec sed -i "" "s|^published: true|published: false|g" {} \;'
    system 'find . -name "*.yml" -exec sed -i "" "s|^published: true|published: false|g" {} \;'
  end

  desc 'Re-publish old posts for deployment'
  task :off => ['jekyll:clean'] do
    system 'find . -name "*.textile" -exec sed -i "" "s|^published: false|published: true|g" {} \;'
    system 'find . -name "*.yml" -exec sed -i "" "s|^published: false|published: true|g" {} \;'
  end

end
