#notification :libnotify

guard 'phpunit2', :cli => '--colors', :tests_path => 'tests', 
        :keep_failed => true, :all_after_pass => true,
	:command => "./vendor/bin/phpunit" do
  watch(%r{^tests/.+Test\.php$})
  watch(%r{^src/(.+)\.php$}) { |m| "tests/#{m[1]}Test.php" }
end
